// Export function for use in dynamically loaded content
window.initCustomVideoControls = function(video) {
    if (!video) return;

    const savePositionUrl = video.dataset.savePositionUrl;
    const startPosition = video.dataset.startPosition;
    
    // Set start position if available, but only after video metadata is loaded
    if (startPosition) {
        const setStartPosition = () => {
            const position = parseInt(startPosition);
            console.log('Video metadata loaded - duration:', video.duration, 'seconds, requested position:', position);
            // Only set position if it's less than video duration with safety margin
            // Don't set position to last 2 seconds to avoid immediate 'ended' event
            const safeMaxPosition = Math.max(0, video.duration - 2);
            if (video.duration && position < safeMaxPosition) {
                video.currentTime = position;
                console.log('Set video position to:', position);
            } else if (video.duration && position >= safeMaxPosition) {
                // If saved position is near the end, set it to safe position
                video.currentTime = Math.max(0, safeMaxPosition);
                console.log('Start position', position, 'too close to end, set to safe position:', Math.max(0, safeMaxPosition));
            } else {
                console.log('Start position', position, 'exceeds video duration', video.duration, '- not setting');
            }
        };
        
        if (video.readyState >= 1) { // HAVE_METADATA
            setStartPosition();
        } else {
            video.addEventListener('loadedmetadata', setStartPosition, { once: true });
        }
    }

    // Allow backward seeking but block forward seeking
    let lastTime = 0;
    let maxReachedTime = 0;
    let isUserSeeking = false;

    video.addEventListener('seeking', function(e) {
        if (!isUserSeeking) return;
        
        if (video.currentTime > maxReachedTime) {
            // User tried to seek forward, revert to max reached position
            console.log('Forward seeking blocked, reverting to:', maxReachedTime);
            video.currentTime = maxReachedTime;
        } else {
            // Backward seeking is allowed
            lastTime = video.currentTime;
        }
        isUserSeeking = false;
    });

    video.addEventListener('seeked', function(e) {
        isUserSeeking = false;
    });

    // Track user interaction with controls
    video.addEventListener('mousedown', function(e) {
        isUserSeeking = true;
    });

    video.addEventListener('touchstart', function(e) {
        isUserSeeking = true;
    });

    // Save position every 5 seconds
    let saveInterval;
    video.addEventListener('play', function() {
        saveInterval = setInterval(savePosition, 5000);
    });

    video.addEventListener('pause', function() {
        clearInterval(saveInterval);
        savePosition(); // Save immediately when paused
    });

    video.addEventListener('ended', function() {
        clearInterval(saveInterval);
        savePosition(); // Save when video ends
        
        // Auto-complete lesson when video ends - but only if video was actually played for reasonable time
        const completeUrl = video.dataset.completeLessonUrl;
        const minWatchTime = 5; // At least 5 seconds should be watched
        
        console.log('Video ended event fired:', {
            currentTime: video.currentTime,
            duration: video.duration,
            minWatchTime: minWatchTime,
            watchedPercent: video.duration ? (video.currentTime / video.duration * 100).toFixed(1) + '%' : 'unknown',
            requiredPercent: '80%',
            meetsMinTime: video.currentTime >= minWatchTime,
            meetsPercentage: video.duration && video.currentTime >= video.duration * 0.8
        });
        
        if (completeUrl && video.currentTime >= minWatchTime && video.duration && video.currentTime >= video.duration * 0.8) {
            console.log('Video ended after sufficient watch time, auto-completing lesson...');
            if (typeof window.completeLesson === 'function') {
                window.completeLesson(completeUrl);
            } else {
                // Fallback: direct AJAX call
                fetch(completeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        console.log('Lesson completed successfully after video end');
                        
                        // If quiz is unlocked, notify parent window
                        if (data.quiz_unlocked && parent && parent.updateQuizStatus) {
                            parent.updateQuizStatus();
                        }
                        if (data.quiz_unlocked && parent && parent.showSuccessMessage) {
                            parent.showSuccessMessage('🎉 Wszystkie lekcje ukończone! Test końcowy został odblokowany.');
                        }
                        
                        // Notify parent window to refresh lessons status
                        if (parent && parent !== window && typeof parent.refreshLessonsAccessibility === 'function') {
                            parent.refreshLessonsAccessibility();
                        }
                        
                        // Update navigation buttons
                        if (parent && parent !== window && typeof parent.updateNavigationButtons === 'function') {
                            setTimeout(() => parent.updateNavigationButtons(), 500);
                        }
                    }
                }).catch(error => {
                    console.error('Error completing lesson after video end:', error);
                });
            }
        } else {
            console.log('Video ended but auto-complete prevented:', {
                currentTime: video.currentTime,
                duration: video.duration,
                minWatchTime: minWatchTime,
                watchedPercent: video.duration ? (video.currentTime / video.duration * 100).toFixed(1) + '%' : 'unknown'
            });
        }
    });

    // Save position when user leaves the page
    window.addEventListener('beforeunload', function() {
        savePosition();
    });

    // Save position when page becomes hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            savePosition();
        }
    });

    function savePosition() {
        if (video.currentTime > 0) {
            fetch(savePositionUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    position: Math.floor(video.currentTime)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Video position saved:', Math.floor(video.currentTime));
                }
            })
            .catch(error => {
                console.error('Error saving video position:', error);
            });
        }
    }

    // Disable keyboard shortcuts for forward seeking
    video.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowRight' || e.key === ' ') {
            e.preventDefault();
        }
    });

    // Disable right-click context menu
    video.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // Update maxReachedTime on timeupdate
    video.addEventListener('timeupdate', function() {
        if (!isUserSeeking) {
            lastTime = video.currentTime;
            // Track the highest position reached
            if (video.currentTime > maxReachedTime) {
                maxReachedTime = video.currentTime;
            }
        }
    });

    // Always use custom controls for better control over seeking
    video.controls = false;
    createCustomControls();

    function createCustomControls() {
        const controlsContainer = document.createElement('div');
        controlsContainer.className = 'video-controls';
        controlsContainer.innerHTML = `
            <button id="play-pause" style="font-size: 16px;">
                ▶
            </button>
            <button id="rewind-10s" style="font-size: 14px; margin-left: 5px;" title="Cofnij o 10 sekund">
                ⏪10s
            </button>
            <span id="time-display">0:00 / 0:00</span>
            <div class="flex-1">
                <div id="progress-fill" style="width: 0%"></div>
            </div>
            <button id="fullscreen" style="font-size: 16px;">
                ⛶
            </button>
        `;
        
        video.parentNode.insertBefore(controlsContainer, video.nextSibling);
        
        const playPauseBtn = document.getElementById('play-pause');
        const rewindBtn = document.getElementById('rewind-10s');
        const timeDisplay = document.getElementById('time-display');
        const fullscreenBtn = document.getElementById('fullscreen');
        const progressFill = document.getElementById('progress-fill');
        
        playPauseBtn.addEventListener('click', function() {
            if (video.paused) {
                video.play();
                playPauseBtn.innerHTML = '⏸';
            } else {
                video.pause();
                playPauseBtn.innerHTML = '▶';
            }
        });

        rewindBtn.addEventListener('click', function() {
            // Rewind by 10 seconds, but don't go below 0
            const newTime = Math.max(0, video.currentTime - 10);
            video.currentTime = newTime;
            console.log('Rewound 10 seconds to:', newTime);
        });
        
        fullscreenBtn.addEventListener('click', function() {
            if (video.requestFullscreen) {
                video.requestFullscreen();
            } else if (video.webkitRequestFullscreen) {
                video.webkitRequestFullscreen();
            }
        });
        
        // Handle progress bar click for seeking
        const progressContainer = document.querySelector('.video-controls .flex-1');
        
        progressContainer.addEventListener('click', function(e) {
            if (video.duration) {
                const rect = progressContainer.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const containerWidth = rect.width;
                const clickPercent = clickX / containerWidth;
                const newTime = clickPercent * video.duration;
                
                // Only allow seeking backward or to current max reached position
                if (newTime <= maxReachedTime) {
                    video.currentTime = newTime;
                }
            }
        });
        
        video.addEventListener('timeupdate', function() {
            if (video.duration) {
                const progress = (video.currentTime / video.duration) * 100;
                progressFill.style.width = progress + '%';
                
                const current = Math.floor(video.currentTime);
                const total = Math.floor(video.duration);
                timeDisplay.textContent = `${formatTime(current)} / ${formatTime(total)}`;
            }
        });
        
        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }
    }
}

// Initialize for static pages (non-AJAX loaded content)
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('lesson-video');
    if (video) {
        initCustomVideoControls(video);
    }
});
