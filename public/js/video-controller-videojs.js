// Video.js Enhanced Player with Custom Controls
// Requires Video.js library to be loaded

// Video.js plugins
videojs.registerPlugin('seekingControl', function(options = {}) {
    const player = this;
    let maxReachedTime = parseFloat(options.startPosition) || 0;
    let isUserSeeking = false;
    let seekingTimeout = null;
    
    // Expose methods for other plugins
    this.updateMaxReachedTime = function(time) {
        maxReachedTime = Math.max(maxReachedTime, time);
        console.log('Max reached time updated externally to:', maxReachedTime);
    };
    
    this.getMaxReachedTime = function() {
        return maxReachedTime;
    };
    
    console.log('seekingControl plugin initialized, startPosition:', options.startPosition, 'maxReachedTime:', maxReachedTime);
    
    // Handle seeking events with debounce to prevent video restart
    player.on('seeking', function() {
        const currentTime = player.currentTime();
        console.log('Seeking to:', currentTime, 'Max reached:', maxReachedTime);
        
        if (currentTime > maxReachedTime) {
            console.log('Forward seeking blocked, will revert to max reached:', maxReachedTime);
            isUserSeeking = true;
            
            // Use setTimeout to avoid immediate currentTime changes that cause restart
            if (seekingTimeout) {
                clearTimeout(seekingTimeout);
            }
            
            seekingTimeout = setTimeout(() => {
                if (player.currentTime() > maxReachedTime) {
                    console.log('Reverting to max reached time:', maxReachedTime);
                    player.currentTime(maxReachedTime);
                }
                isUserSeeking = false;
            }, 100);
        }
    });
    
    // Handle seeked event to ensure we don't go beyond max time
    player.on('seeked', function() {
        const currentTime = player.currentTime();
        if (currentTime > maxReachedTime && !isUserSeeking) {
            console.log('Seeked beyond max time, correcting to:', maxReachedTime);
            player.currentTime(maxReachedTime);
        }
    });
    
    // Track user interactions
    player.on('useractive', function() {
        // Don't set seeking flag immediately, let the timeout handle it
    });
    
    // Update max reached time during normal playback
    player.on('timeupdate', function() {
        const currentTime = player.currentTime();
        // Always update max reached time if video is playing normally (not seeking)
        if (currentTime > maxReachedTime && !player.seeking() && !player.paused() && !isUserSeeking) {
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

    console.log('🔍 DEBUG positionSaver plugin initialized with options:', options);
    
    function savePosition() {
        const currentTime = Math.floor(player.currentTime());
        console.log('🔍 DEBUG savePosition called', {
            currentTime: currentTime,
            saveUrl: saveUrl,
            hasToken: !!document.querySelector('meta[name="csrf-token"]')
        });

        if (currentTime > 0 && saveUrl) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const csrfValue = csrfToken ? csrfToken.getAttribute('content') : 'NO_TOKEN';

            console.log('🔍 DEBUG sending AJAX request to save position');
            console.log('🔍 DEBUG CSRF token:', csrfValue);

            fetch(saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfValue
                },
                body: JSON.stringify({
                    position: currentTime
                })
            })
            .then(response => {
                console.log('🔍 DEBUG Response status:', response.status);
                if (response.status === 419) {
                    console.error('🔍 DEBUG CSRF token expired! Status 419');
                    return Promise.reject('CSRF token expired');
                }
                if (!response.ok) {
                    console.error('🔍 DEBUG HTTP error:', response.status, response.statusText);
                    return Promise.reject(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('🔍 DEBUG Video position saved successfully:', currentTime);
                } else {
                    console.error('🔍 DEBUG Save failed with response:', data);
                }
            })
            .catch(error => {
                console.error('🔍 DEBUG Error saving video position:', error);
            });
        } else {
            console.log('🔍 DEBUG not saving position - currentTime or saveUrl missing', {
                currentTime: currentTime,
                saveUrl: saveUrl
            });
        }
    }
    
    // Set start position and update seeking control
    if (options.startPosition) {
        console.log('🔍 DEBUG startPosition provided:', options.startPosition);

        function setVideoPosition() {
            const position = parseInt(options.startPosition);
            const duration = player.duration();
            const safeMaxPosition = Math.max(0, duration - 2);

            console.log('🔍 DEBUG setting video position:', {
                position: position,
                duration: duration,
                safeMaxPosition: safeMaxPosition,
                willSet: duration && position < safeMaxPosition
            });

            if (duration && !isNaN(duration) && position < safeMaxPosition) {
                player.currentTime(position);
                console.log('🔍 DEBUG Set video position to:', position);

                // Update maxReachedTime in seekingControl plugin
                if (player.seekingControl && player.seekingControl.updateMaxReachedTime) {
                    player.seekingControl.updateMaxReachedTime(position);
                }
            } else {
                console.log('🔍 DEBUG NOT setting position - condition failed:', {
                    hasDuration: !!duration,
                    durationIsValid: !isNaN(duration),
                    positionValid: duration && position < safeMaxPosition
                });
            }
        }

        // Wait for video metadata to load (including duration)
        player.ready(() => {
            if (player.duration() && !isNaN(player.duration())) {
                console.log('🔍 DEBUG Duration available immediately, setting position');
                setVideoPosition();
            } else {
                console.log('🔍 DEBUG Duration not available, waiting for loadedmetadata');
                player.one('loadedmetadata', () => {
                    console.log('🔍 DEBUG loadedmetadata fired, setting position');
                    setVideoPosition();
                });
            }
        });
    } else {
        console.log('🔍 DEBUG No startPosition provided');
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

// Custom progress overlay plugin (only progress bar on video)
videojs.registerPlugin('customProgressOverlay', function(options = {}) {
    const player = this;
    const progressOverlay = document.getElementById('custom-progress-overlay');
    const progressBar = document.getElementById('custom-progress-bar');
    
    if (!progressOverlay || !progressBar) {
        console.log('Custom progress elements not found');
        return;
    }
    
    // Update progress bar
    function updateProgress() {
        const duration = player.duration();
        const currentTime = player.currentTime();
        
        if (duration > 0) {
            const progress = (currentTime / duration) * 100;
            progressBar.style.width = progress + '%';
        }
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
    
    // Update progress during playback
    player.on('timeupdate', updateProgress);
    player.on('seeking', updateProgress);
    player.on('seeked', updateProgress);
    
    // Initial update
    player.ready(updateProgress);
});

// Main initialization function
window.initVideoJSPlayer = function(videoElement, options = {}) {
    if (!videoElement) {
        console.error('🔍 DEBUG initVideoJSPlayer called with no video element');
        return;
    }

    console.log('🔍 DEBUG initVideoJSPlayer called with video element:', videoElement);
    console.log('🔍 DEBUG initVideoJSPlayer options:', options);
    
    const playerOptions = {
        controls: true,
        responsive: true,
        fluid: true,
        controlBar: {
            children: [
                'playToggle',
                'currentTimeDisplay', 
                'timeDivider',
                'durationDisplay',
                'muteToggle',
                'fullscreenToggle'
            ]
        },
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
            customProgressOverlay: {}
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