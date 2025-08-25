// Video.js Enhanced Player with Custom Controls
// Requires Video.js library to be loaded

// Video.js plugins
videojs.registerPlugin('seekingControl', function(options = {}) {
    const player = this;
    let maxReachedTime = parseFloat(options.startPosition) || 0;
    let isUserSeeking = false;
    
    console.log('seekingControl plugin initialized, startPosition:', options.startPosition, 'maxReachedTime:', maxReachedTime);
    
    // Handle seeking events
    player.on('seeking', function() {
        const currentTime = player.currentTime();
        console.log('Seeking to:', currentTime, 'Max reached:', maxReachedTime);
        
        if (currentTime > maxReachedTime) {
            console.log('Forward seeking blocked, reverting to max reached:', maxReachedTime);
            player.currentTime(maxReachedTime);
        }
    });
    
    // Track user interactions
    player.on('useractive', function() {
        isUserSeeking = true;
    });
    
    // Update max reached time during normal playback
    player.on('timeupdate', function() {
        const currentTime = player.currentTime();
        // Always update max reached time if video is playing normally (not seeking)
        if (currentTime > maxReachedTime && !player.seeking() && !player.paused()) {
            maxReachedTime = currentTime;
            console.log('Max reached time updated to:', maxReachedTime.toFixed(2));
        }
    });
    
    // Make sure we start tracking from the beginning if no start position
    player.ready(() => {
        if (!options.startPosition && player.currentTime() === 0) {
            maxReachedTime = 0;
            console.log('No start position, maxReachedTime set to 0');
        }
    });
    
    // Disable keyboard shortcuts for forward seeking
    player.on('keydown', function(event) {
        if (event.which === 39 || event.which === 32) { // Right arrow or Space
            event.preventDefault();
        }
    });
    
    // Block seeking in fullscreen
    player.on('fullscreenchange', function() {
        if (player.isFullscreen()) {
            // Additional controls for fullscreen
            player.ready(() => {
                const seekBar = player.controlBar.progressControl.seekBar;
                seekBar.off('mousedown touchstart');
                seekBar.on('mousedown touchstart', function(event) {
                    event.preventDefault();
                    const rect = this.el().getBoundingClientRect();
                    const clickX = event.clientX - rect.left;
                    const percent = clickX / rect.width;
                    const newTime = percent * player.duration();
                    
                    if (newTime <= maxReachedTime) {
                        player.currentTime(newTime);
                    }
                });
            });
        }
    });
});

videojs.registerPlugin('positionSaver', function(options = {}) {
    const player = this;
    const saveUrl = options.saveUrl;
    let saveInterval;
    
    function savePosition() {
        const currentTime = Math.floor(player.currentTime());
        if (currentTime > 0 && saveUrl) {
            fetch(saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    position: currentTime
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Video position saved:', currentTime);
                }
            })
            .catch(error => {
                console.error('Error saving video position:', error);
            });
        }
    }
    
    // Set start position
    if (options.startPosition) {
        player.ready(() => {
            const position = parseInt(options.startPosition);
            const safeMaxPosition = Math.max(0, player.duration() - 2);
            
            if (player.duration() && position < safeMaxPosition) {
                player.currentTime(position);
                console.log('Set video position to:', position);
            }
        });
    }
    
    // Save position events
    player.on('play', function() {
        saveInterval = setInterval(savePosition, 5000);
    });
    
    player.on('pause', function() {
        clearInterval(saveInterval);
        savePosition();
    });
    
    player.on('ended', function() {
        console.log('VIDEO.JS ENDED EVENT FIRED!');
        clearInterval(saveInterval);
        savePosition();
        
        // Auto-complete lesson
        const completeUrl = options.completeUrl;
        const minWatchTime = 5;
        const currentTime = player.currentTime();
        const duration = player.duration();
        
        console.log('Video ended event fired:', {
            completeUrl: completeUrl,
            currentTime: currentTime,
            duration: duration,
            minWatchTime: minWatchTime,
            watchedPercent: duration ? (currentTime / duration * 100).toFixed(1) + '%' : 'unknown',
            requiredPercent: '80%',
            meetsMinTime: currentTime >= minWatchTime,
            meetsPercentage: duration && currentTime >= duration * 0.8
        });
        
        if (completeUrl && currentTime >= minWatchTime && duration && currentTime >= duration * 0.8) {
            console.log('Video ended after sufficient watch time, auto-completing lesson...');
            
            if (typeof window.completeLesson === 'function') {
                window.completeLesson(completeUrl);
            } else {
                fetch(completeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        console.log('Lesson completed successfully after video end');
                        
                        // Update lesson status in sidebar immediately
                        const lessonItem = document.querySelector('.lesson-item.active');
                        if (lessonItem) {
                            lessonItem.classList.add('completed');
                            const statusElement = lessonItem.querySelector('.lesson-status');
                            if (statusElement) {
                                statusElement.textContent = '✓ Ukończona';
                            }
                        }
                        
                        if (data.quiz_unlocked && parent && parent.updateQuizStatus) {
                            parent.updateQuizStatus();
                        }
                        if (data.quiz_unlocked && parent && parent.showSuccessMessage) {
                            parent.showSuccessMessage('🎉 Wszystkie lekcje ukończone! Test końcowy został odblokowany.');
                        }
                        
                        if (parent && parent !== window && typeof parent.refreshLessonsAccessibility === 'function') {
                            console.log('Calling parent.refreshLessonsAccessibility after lesson completion');
                            parent.refreshLessonsAccessibility();
                        } else if (typeof refreshLessonsAccessibility === 'function') {
                            console.log('Calling refreshLessonsAccessibility directly');
                            refreshLessonsAccessibility();
                        } else {
                            console.log('refreshLessonsAccessibility function not found');
                        }
                        
                        if (parent && parent !== window && typeof parent.updateNavigationButtons === 'function') {
                            console.log('Calling parent.updateNavigationButtons after lesson completion');
                            setTimeout(() => parent.updateNavigationButtons(), 500);
                            // Try again after longer delay in case DOM needs more time
                            setTimeout(() => {
                                console.log('Calling parent.updateNavigationButtons again after 2s');
                                parent.updateNavigationButtons();
                            }, 2000);
                        } else if (typeof updateNavigationButtons === 'function') {
                            console.log('Calling updateNavigationButtons directly');
                            setTimeout(() => updateNavigationButtons(), 500);
                        }
                        
                        // Show success message
                        if (window.showSuccessMessage) {
                            window.showSuccessMessage('Lekcja została ukończona!');
                        }
                    }
                }).catch(error => {
                    console.error('Error completing lesson after video end:', error);
                });
            }
        }
    });
    
    // Save on page unload
    window.addEventListener('beforeunload', function() {
        savePosition();
    });
});

videojs.registerPlugin('visibilityControl', function(options = {}) {
    const player = this;
    
    // Pause when page becomes hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (!player.paused()) {
                player.pause();
                console.log('Video paused due to page visibility change');
            }
        }
    });
    
    // Pause when window loses focus
    window.addEventListener('blur', function() {
        if (!player.paused()) {
            player.pause();
            console.log('Video paused due to window blur');
        }
    });
});

// Custom controls plugin
videojs.registerPlugin('customControls', function(options = {}) {
    const player = this;
    const progressOverlay = document.getElementById('custom-progress-overlay');
    const progressBar = document.getElementById('custom-progress-bar');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const timeDisplay = document.getElementById('time-display');
    const muteBtn = document.getElementById('mute-btn');
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    
    if (!progressOverlay || !progressBar || !playPauseBtn || !timeDisplay || !muteBtn || !fullscreenBtn) {
        console.log('Custom control elements not found');
        return;
    }
    
    // Format time helper
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
    
    // Update progress bar and time
    function updateProgress() {
        const duration = player.duration();
        const currentTime = player.currentTime();
        
        if (duration > 0) {
            const progress = (currentTime / duration) * 100;
            progressBar.style.width = progress + '%';
            timeDisplay.textContent = `${formatTime(currentTime)} / ${formatTime(duration)}`;
        }
    }
    
    // Update play/pause button
    function updatePlayButton() {
        playPauseBtn.textContent = player.paused() ? '▶️' : '⏸️';
    }
    
    // Update mute button
    function updateMuteButton() {
        muteBtn.textContent = player.muted() || player.volume() === 0 ? '🔇' : '🔊';
    }
    
    // Handle clicks on progress bar
    progressOverlay.addEventListener('click', function(e) {
        const rect = progressOverlay.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const width = rect.width;
        const clickPercent = clickX / width;
        const duration = player.duration();
        
        if (duration > 0) {
            const seekTime = clickPercent * duration;
            player.currentTime(seekTime);
        }
    });
    
    // Play/pause button
    playPauseBtn.addEventListener('click', function() {
        if (player.paused()) {
            player.play();
        } else {
            player.pause();
        }
    });
    
    // Mute button
    muteBtn.addEventListener('click', function() {
        player.muted(!player.muted());
    });
    
    // Fullscreen button
    fullscreenBtn.addEventListener('click', function() {
        if (player.isFullscreen()) {
            player.exitFullscreen();
        } else {
            player.requestFullscreen();
        }
    });
    
    // Update controls during playback
    player.on('timeupdate', updateProgress);
    player.on('seeking', updateProgress);
    player.on('seeked', updateProgress);
    player.on('play', updatePlayButton);
    player.on('pause', updatePlayButton);
    player.on('volumechange', updateMuteButton);
    
    // Initial updates
    player.ready(() => {
        updateProgress();
        updatePlayButton();
        updateMuteButton();
    });
});

// Main initialization function
window.initVideoJSPlayer = function(videoElement, options = {}) {
    if (!videoElement) return;
    
    console.log('initVideoJSPlayer called with options:', options);
    
    const playerOptions = {
        controls: false, // Disable default controls
        responsive: true,
        fluid: true,
        plugins: {
            seekingControl: {
                startPosition: options.startPosition || 0
            },
            positionSaver: {
                saveUrl: options.saveUrl,
                startPosition: options.startPosition || 0,
                completeUrl: options.completeUrl
            },
            visibilityControl: {},
            customControls: {}
        }
    };
    
    // Initialize Video.js player
    const player = videojs(videoElement, playerOptions);
    
    // Disable right-click context menu
    player.ready(() => {
        player.el().addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    });
    
    return player;
};

// Initialize for static pages
document.addEventListener('DOMContentLoaded', function() {
    // Check if Video.js is loaded
    if (typeof videojs === 'undefined') {
        console.error('Video.js library not loaded');
        return;
    }
    
    const videoElement = document.getElementById('lesson-video');
    if (videoElement) {
        const options = {
            saveUrl: videoElement.dataset.savePositionUrl,
            startPosition: videoElement.dataset.startPosition,
            completeUrl: videoElement.dataset.completeLessonUrl
        };
        
        window.initVideoJSPlayer(videoElement, options);
    }
});