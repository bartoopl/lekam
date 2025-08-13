// Export function for use in dynamically loaded content
window.initCustomVideoControls = function(video) {
    if (!video) return;

    const savePositionUrl = video.dataset.savePositionUrl;
    const startPosition = video.dataset.startPosition;
    
    // Set start position if available
    if (startPosition) {
        video.currentTime = parseInt(startPosition);
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
