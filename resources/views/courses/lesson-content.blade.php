<div class="lesson-header">
    <h2 class="lesson-title-main">{{ $lesson->title }}</h2>
    
    @if($lesson->content)
        <div class="lesson-description prose max-w-none">
            {!! $lesson->content !!}
        </div>
    @else
        <div class="lesson-description text-gray-500 italic">
            Brak treści lekcji
        </div>
    @endif
</div>

@if($lesson->video_file)
    <div class="lesson-video">
        <h3 class="materials-title">Wideo</h3>
        <div class="video-container">
            <video id="lesson-video" class="w-full rounded-lg" preload="metadata"
                data-lesson-id="{{ $lesson->id }}" data-course-id="{{ $course->id }}"
                data-save-position-url="{{ route('courses.save-video-position', ['course' => $course, 'lesson' => $lesson]) }}"
                data-complete-lesson-url="{{ route('courses.complete-lesson', ['course' => $course, 'lesson' => $lesson]) }}"
                @if($userProgress && $userProgress->video_position) data-start-position="{{ $userProgress->video_position }}" @endif>
                <source src="{{ str_starts_with($lesson->video_file, 'http') ? $lesson->video_file : Storage::url($lesson->video_file) }}" type="video/mp4">
                Twoja przeglądarka nie obsługuje odtwarzania wideo.
            </video>
        </div>
    </div>


@endif


@if($lesson->hasDownloadableMaterials())
    <style>
        .material-download {
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%) !important;
            color: white !important;
            border: none !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 12px !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            min-width: 200px !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        .material-download:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4) !important;
            color: white !important;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%) !important;
        }
        
        .material-item {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        .material-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
    </style>
    
    <div class="lesson-materials">
        <h3 class="materials-title">Materiały do pobrania</h3>
        
        <!-- Timer Display -->
        @if($lesson->download_timer_minutes && $lesson->download_timer_minutes > 0)
            <div id="timer-info" class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg" style="display: none;">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-blue-800">Czas do ukończenia lekcji: <span id="timer-display" class="font-bold">{{ $lesson->download_timer_minutes }}:00</span></span>
                </div>
            </div>
        @endif
        
        <!-- Download Status -->
        @if($userProgress && $userProgress->file_downloaded_at)
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-green-800">Materiały zostały pobrane {{ $userProgress->file_downloaded_at->diffForHumans() }}</span>
                </div>
                @if($userProgress->can_proceed_after && now()->lt($userProgress->can_proceed_after))
                    <div class="mt-2 text-green-700">
                        <span>Kolejna lekcja będzie dostępna {{ $userProgress->can_proceed_after->diffForHumans() }}</span>
                    </div>
                @endif
            </div>
        @endif
        
        @foreach($lesson->downloadable_materials as $material)
            <div class="material-item">
                <div class="material-icon">
                    <span style="font-size: 24px;">📄</span>
                </div>
                <div class="material-info">
                    <div class="material-name">{{ $material['name'] }}</div>
                    <div class="material-size">{{ $material['size'] ?? 'Nieznany rozmiar' }}</div>
                </div>
                <a href="{{ route('courses.download-file', ['course' => $course, 'lesson' => $lesson]) }}?file={{ urlencode($material['name']) }}" 
                   class="material-download" 
                   onclick="handleMaterialDownload(event)"
                   data-lesson-id="{{ $lesson->id }}"
                   data-course-id="{{ $course->id }}"
                   data-complete-lesson-url="{{ route('courses.complete-lesson', ['course' => $course, 'lesson' => $lesson]) }}"
                   data-download-timer="{{ $lesson->download_timer_minutes ?? 0 }}">
                    ⬇️ POBIERZ MATERIAŁY
                </a>
            </div>
        @endforeach
    </div>

    <script>
        let countdownInterval = null;
        
        function handleMaterialDownload(event) {
            event.preventDefault();
            const link = event.target.closest('.material-download');
            const lessonId = link.dataset.lessonId;
            const courseId = link.dataset.courseId;
            const completeUrl = link.dataset.completeLessonUrl;
            const timerMinutes = parseInt(link.dataset.downloadTimer) || 0;
            
            // Trigger actual download
            window.location.href = link.href;
            
            // Update download tracking on backend
            fetch('{{ route("courses.download-file", ["course" => $course, "lesson" => $lesson]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    action: 'mark_downloaded'
                })
            });
            
            // Start timer if configured
            if (timerMinutes > 0) {
                startDownloadTimer(timerMinutes, completeUrl);
            } else {
                // Complete immediately if no timer
                setTimeout(() => completeLesson(completeUrl), 1000);
            }
        }
        
        window.startDownloadTimer = function(minutes, completeUrl) {
            const timerInfo = document.getElementById('timer-info');
            const timerDisplay = document.getElementById('timer-display');
            
            if (timerInfo) {
                timerInfo.style.display = 'block';
            }
            
            let totalSeconds = minutes * 60;
            
            function updateDisplay() {
                const mins = Math.floor(totalSeconds / 60);
                const secs = totalSeconds % 60;
                const display = `${mins}:${secs.toString().padStart(2, '0')}`;
                
                if (timerDisplay) {
                    timerDisplay.textContent = display;
                }
                
                if (totalSeconds <= 0) {
                    clearInterval(countdownInterval);
                    completeLesson(completeUrl);
                    if (timerInfo) {
                        timerInfo.innerHTML = `
                            <div class="flex items-center text-green-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-bold">Czas minął! Lekcja została ukończona.</span>
                            </div>
                        `;
                    }
                    
                    // Show success notification
                    showSuccessMessage('Timer zakończony! Możesz przejść do kolejnej lekcji.');
                    return;
                }
                
                totalSeconds--;
            }
            
            // Update immediately and then every second
            updateDisplay();
            countdownInterval = setInterval(updateDisplay, 1000);
        }
        
        window.completeLesson = function(completeUrl) {
            fetch(completeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    // Update UI to show lesson as completed
                    const lessonItem = document.querySelector('.lesson-item.active');
                    if (lessonItem) {
                        lessonItem.classList.add('completed');
                        const statusElement = lessonItem.querySelector('.lesson-status');
                        if (statusElement) {
                            statusElement.textContent = '✓ Ukończona';
                        }
                    }
                    
                    // Show success message
                    if (parent && parent.showSuccessMessage) {
                        parent.showSuccessMessage('Lekcja została oznaczona jako ukończona!');
                    } else if (window.showSuccessMessage) {
                        showSuccessMessage('Lekcja została oznaczona jako ukończona!');
                    }
                    
                    // Notify parent window to refresh lessons status
                    if (parent && parent !== window && typeof parent.refreshLessonsAccessibility === 'function') {
                        parent.refreshLessonsAccessibility();
                    }
                }
            }).catch(error => {
                console.error('Error completing lesson:', error);
            });
        }
        
        window.showSuccessMessage = function(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Remove notification after 5 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 5000);
        }
    </script>
@endif



@if(!$lesson->hasDownloadableMaterials() && ($lesson->requires_download_completion || stripos($lesson->title, 'materiały do pobrania') !== false || stripos($lesson->title, 'materialy do pobrania') !== false))
    <style>
        .material-download {
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%) !important;
            color: white !important;
            border: none !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 12px !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            min-width: 200px !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        .material-download:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4) !important;
            color: white !important;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%) !important;
        }
        
        .material-download:disabled {
            opacity: 0.7 !important;
            cursor: not-allowed !important;
            transform: none !important;
            background: #9ca3af !important;
            color: white !important;
        }
        
        .material-item {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        .material-item:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        
        .material-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .material-info {
            flex: 1;
            margin-right: 1rem;
        }
        
        .material-name {
            font-weight: 700;
            color: #21235F;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .material-size {
            font-size: 0.9rem;
            color: #666;
        }
    </style>

    <div class="lesson-materials">
        <h3 class="materials-title">Materiały do pobrania</h3>
        
        <!-- Show lesson content if available -->
        @if($lesson->content)
            <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <div class="prose max-w-none">
                    {!! $lesson->content !!}
                </div>
            </div>
        @endif
        
        @if(!$lesson->hasDownloadableMaterials())
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-blue-800"><strong>Instrukcje:</strong> Pobierz materiały używając przycisku poniżej i poczekaj na zakończenie timera.</span>
                </div>
            </div>
        @endif
        
        <!-- Download button (show only if not downloaded yet) -->
        @if(!$userProgress || !$userProgress->file_downloaded_at)
            @if($lesson->hasDownloadableMaterials())
                @foreach($lesson->downloadable_materials as $material)
                    <div class="material-item">
                        <div class="material-icon">
                            <span style="font-size: 24px;">📄</span>
                        </div>
                        <div class="material-info">
                            <div class="material-name">{{ $material['name'] }}</div>
                            <div class="material-size">{{ $material['size'] ?? 'Nieznany rozmiar' }}</div>
                        </div>
                        <a href="{{ route('courses.download-file', ['course' => $course, 'lesson' => $lesson]) }}?file={{ urlencode($material['name']) }}" 
                           class="material-download" 
                           onclick="handleMaterialDownload(event)"
                           data-lesson-id="{{ $lesson->id }}"
                           data-course-id="{{ $course->id }}"
                           data-complete-lesson-url="{{ route('courses.complete-lesson', ['course' => $course, 'lesson' => $lesson]) }}"
                           data-download-timer="{{ $lesson->download_timer_minutes ?? 0 }}">
                            ⬇️ POBIERZ MATERIAŁY
                        </a>
                    </div>
                @endforeach
            @else
                {{-- Fallback for lessons without real materials but with timer --}}
                <div class="material-item">
                    <div class="material-icon">
                        <span style="font-size: 24px;">📄</span>
                    </div>
                    <div class="material-info">
                        <div class="material-name">📁 Materiały szkoleniowe</div>
                        <div class="material-size">⏱️ Timer: {{ $lesson->download_timer_minutes ?? 2 }} min</div>
                    </div>
                    <a href="{{ route('courses.download-file', ['course' => $course, 'lesson' => $lesson]) }}" 
                       class="material-download" 
                       onclick="handleMaterialDownload(event)"
                       data-lesson-id="{{ $lesson->id }}"
                       data-course-id="{{ $course->id }}"
                       data-complete-lesson-url="{{ route('courses.complete-lesson', ['course' => $course, 'lesson' => $lesson]) }}"
                       data-download-timer="{{ $lesson->download_timer_minutes ?? 0 }}">
                        ⬇️ POBIERZ MATERIAŁY
                    </a>
                </div>
            @endif
        @else
            <!-- Materials already downloaded -->
            <div class="material-item">
                <div class="material-icon bg-green-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="material-info">
                    <div class="material-name">✅ Materiały zostały pobrane</div>
                    <div class="material-size">📅 {{ $userProgress->file_downloaded_at->format('d.m.Y H:i') }}</div>
                </div>
                <div class="text-green-600 font-semibold px-4">
                    Pobrano
                </div>
            </div>
        @endif
        
        <!-- Timer Display -->
        @if($userProgress && $userProgress->file_downloaded_at)
            @if($userProgress->can_proceed_after && now()->lt($userProgress->can_proceed_after))
                <!-- Timer still running -->
                @php
                    $canProceedAfter = $userProgress->can_proceed_after;
                    $now = now();
                    
                    // If timer already expired, show as expired
                    if ($now->isAfter($canProceedAfter)) {
                        $remainingSeconds = 0;
                    } else {
                        $remainingSeconds = $canProceedAfter->diffInSeconds($now);
                    }
                    
                    $remainingMinutes = floor($remainingSeconds / 60);
                    $remainingSecondsOnly = $remainingSeconds % 60;
                @endphp
                <div id="timer-info" class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-blue-800">Czas do ukończenia lekcji: <span id="timer-display" class="font-bold">{{ sprintf('%d:%02d', $remainingMinutes, $remainingSecondsOnly) }}</span></span>
                    </div>
                    <div class="mt-2 text-sm text-blue-700">
                        Materiały pobrane: {{ $userProgress->file_downloaded_at->format('d.m.Y H:i') }}
                    </div>
                </div>
                
                <script>
                    // Continue countdown from server time
                    let remainingTime = {{ $remainingSeconds }};
                    const timerDisplay = document.getElementById('timer-display');
                    const timerInfo = document.getElementById('timer-info');
                    
                    const countdown = setInterval(() => {
                        const mins = Math.floor(remainingTime / 60);
                        const secs = remainingTime % 60;
                        const display = mins + ':' + (secs < 10 ? '0' : '') + secs;
                        
                        if (timerDisplay) {
                            timerDisplay.textContent = display;
                        }
                        
                        if (remainingTime <= 0) {
                            clearInterval(countdown);
                            // Reload page to update UI
                            window.location.reload();
                            return;
                        }
                        remainingTime--;
                    }, 1000);
                </script>
            @else
                <!-- Timer expired -->
                <div id="timer-info" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-bold">Timer zakończony! Lekcja została ukończona.</span>
                    </div>
                    <div class="mt-2 text-sm text-green-700">
                        Zakończono: {{ $userProgress->can_proceed_after->format('d.m.Y H:i') }}
                    </div>
                </div>
                
                <script>
                    // Auto-complete lesson if not already completed
                    @if(!$userProgress->is_completed)
                        fetch('{{ route("courses.complete-lesson", ["course" => $course, "lesson" => $lesson]) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        }).then(response => {
                            if (response.ok) {
                                // Update lesson status in sidebar
                                const lessonItem = document.querySelector('.lesson-item.active');
                                if (lessonItem) {
                                    lessonItem.classList.add('completed');
                                    const statusElement = lessonItem.querySelector('.lesson-status');
                                    if (statusElement) {
                                        statusElement.textContent = '✓ Ukończona';
                                    }
                                }
                                
                                // Reload after short delay to update quiz status
                                setTimeout(() => {
                                    window.parent.location.reload();
                                }, 1500);
                            }
                        }).catch(error => {
                            console.error('Error completing lesson:', error);
                        });
                    @endif
                </script>
            @endif
        @elseif($lesson->download_timer_minutes && $lesson->download_timer_minutes > 0)
            <!-- Timer not started yet -->
            <div id="timer-info" class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg" style="display: none;">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-gray-800">Timer: <span id="timer-display" class="font-bold">{{ $lesson->download_timer_minutes }}:00</span></span>
                </div>
            </div>
        @endif
    </div>
    
    <script>
        let countdownInterval = null;
        
        // Make function globally available
        window.handleMockDownload = function(event) {
            event.preventDefault();
            const button = event.target.closest('.material-download');
            const lessonId = button.dataset.lessonId;
            const courseId = button.dataset.courseId;
            const completeUrl = button.dataset.completeLessonUrl;
            const timerMinutes = parseInt(button.dataset.downloadTimer) || 2;
            
            // Show mock download notification
            showSuccessMessage('Symulacja pobierania - timer rozpoczęty!');
            
            // Update button state
            button.disabled = true;
            button.innerHTML = `
                <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Pobrano - Timer aktywny
            `;
            
            // Start timer
            startDownloadTimer(timerMinutes, completeUrl);
        }
        
        window.startDownloadTimer = function(minutes, completeUrl) {
            const timerInfo = document.getElementById('timer-info');
            const timerDisplay = document.getElementById('timer-display');
            
            if (timerInfo) {
                timerInfo.style.display = 'block';
            }
            
            let totalSeconds = minutes * 60;
            
            function updateDisplay() {
                const mins = Math.floor(totalSeconds / 60);
                const secs = totalSeconds % 60;
                const display = `${mins}:${secs.toString().padStart(2, '0')}`;
                
                if (timerDisplay) {
                    timerDisplay.textContent = display;
                }
                
                if (totalSeconds <= 0) {
                    clearInterval(countdownInterval);
                    completeLesson(completeUrl);
                    if (timerInfo) {
                        timerInfo.innerHTML = `
                            <div class="flex items-center text-green-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-bold">Czas minął! Lekcja została ukończona.</span>
                            </div>
                        `;
                    }
                    
                    // Show success notification
                    showSuccessMessage('Timer zakończony! Możesz przejść do kolejnej lekcji.');
                    return;
                }
                
                totalSeconds--;
            }
            
            // Update immediately and then every second
            updateDisplay();
            countdownInterval = setInterval(updateDisplay, 1000);
        }
        
        window.completeLesson = function(completeUrl) {
            fetch(completeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    // Update UI to show lesson as completed
                    const lessonItem = document.querySelector('.lesson-item.active');
                    if (lessonItem) {
                        lessonItem.classList.add('completed');
                        const statusElement = lessonItem.querySelector('.lesson-status');
                        if (statusElement) {
                            statusElement.textContent = '✓ Ukończona';
                        }
                    }
                    
                    // Show success message
                    if (parent && parent.showSuccessMessage) {
                        parent.showSuccessMessage('Lekcja została oznaczona jako ukończona!');
                    } else if (window.showSuccessMessage) {
                        showSuccessMessage('Lekcja została oznaczona jako ukończona!');
                    }
                    
                    // Notify parent window to refresh lessons status
                    if (parent && parent !== window && typeof parent.refreshLessonsAccessibility === 'function') {
                        parent.refreshLessonsAccessibility();
                    }
                }
            }).catch(error => {
                console.error('Error completing lesson:', error);
            });
        }
        
        window.showSuccessMessage = function(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Remove notification after 5 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 5000);
        }
    </script>
@endif

<!-- Navigation Buttons -->
<div class="lesson-navigation-buttons mt-6">
    <div class="flex items-center justify-between gap-4">
        <button id="lesson-prev-btn" 
                class="inline-flex items-center justify-center px-6 py-3 bg-gray-400 border-2 border-gray-400 rounded-full font-semibold text-sm text-white tracking-wide cursor-not-allowed transition-all duration-300 shadow-lg hover:shadow-xl" 
                style="background: #9ca3af !important; border-color: #9ca3af !important; min-width: 150px; height: 50px; color: white !important;"
                disabled>
            ← Poprzednia
        </button>
        
        <button id="lesson-next-btn" 
                class="inline-flex items-center justify-center px-6 py-3 bg-gray-400 border-2 border-gray-400 rounded-full font-semibold text-sm text-white tracking-wide cursor-not-allowed transition-all duration-300 shadow-lg hover:shadow-xl" 
                style="background: #9ca3af !important; border-color: #9ca3af !important; min-width: 150px; height: 50px; color: white !important;"
                disabled>
            Następna →
        </button>
    </div>
</div>

@if($lesson->instructor)
    <div class="instructor-info">
        @if($lesson->instructor->avatar)
            <img src="{{ Storage::url($lesson->instructor->avatar) }}" alt="{{ $lesson->instructor->name }}" class="instructor-avatar">
        @else
            <div class="instructor-avatar bg-gray-300 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        @endif
        <div class="instructor-details">
            <div class="instructor-name">{{ $lesson->instructor->name }}</div>
            <div class="instructor-title">{{ $lesson->instructor->title ?? 'Wykładowca' }}</div>
        </div>
    </div>
@endif


