<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->title }} - {{ $lesson->title }}
            </h2>
            <div class="flex items-center space-x-4">
                @if($previousLesson)
                    <a href="{{ route('courses.lesson', ['course' => $course, 'lesson' => $previousLesson]) }}" 
                       class="text-blue-600 hover:text-blue-800">
                        ← Poprzednia
                    </a>
                @endif
                @if($nextLesson)
                    <a href="{{ route('courses.lesson', ['course' => $course, 'lesson' => $nextLesson]) }}" 
                       class="text-blue-600 hover:text-blue-800">
                        Następna →
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Lesson Header -->
            <div class="bg-white rounded-lg shadow-sm mb-8">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold mb-2">{{ $lesson->title }}</h1>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>Lekcja {{ $lesson->order }}</span>
                                @if($lesson->is_first_lesson)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Pierwsza lekcja</span>
                                @endif
                                @if($lesson->is_last_lesson)
                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">Ostatnia lekcja</span>
                                @endif
                                @if($lesson->requires_file_download)
                                    <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">Wymaga pobrania pliku</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($userProgress && $userProgress->is_completed)
                            <div class="flex items-center text-green-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Ukończona
                            </div>
                        @endif
                    </div>
                </div>

                <!-- File Download Section -->
                @if($lesson->file_path)
                    <div class="p-6 border-b border-gray-200 bg-blue-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Materiały do pobrania</h3>
                                <p class="text-sm text-gray-600">Pobierz plik, aby kontynuować naukę</p>
                            </div>
                            <a href="{{ route('courses.download-file', ['course' => $course, 'lesson' => $lesson]) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Pobierz plik
                            </a>
                        </div>
                        
                        @if($userProgress && $userProgress->file_downloaded_at)
                            <div class="mt-4 p-3 bg-green-100 rounded-md">
                                <div class="flex items-center text-green-800">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Plik został pobrany {{ $userProgress->file_downloaded_at->diffForHumans() }}
                                </div>
                                @if($userProgress->can_proceed_after && now()->lt($userProgress->can_proceed_after))
                                    <p class="text-sm text-green-700 mt-1">
                                        Możesz kontynuować za {{ $userProgress->can_proceed_after->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Video Section -->
                @if($lesson->video_url || $lesson->video_file)
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-4">Wideo lekcja</h3>
                        
                        @if($lesson->video_file)
                            <div class="mb-4">
                                <video 
                                    id="lesson-video" 
                                    class="w-full rounded-lg" 
                                    preload="metadata"
                                    controls
                                    data-lesson-id="{{ $lesson->id }}"
                                    data-course-id="{{ $course->id }}"
                                    data-save-position-url="{{ route('courses.save-video-position', ['course' => $course, 'lesson' => $lesson]) }}"
                                    @if($userProgress && $userProgress->video_position)
                                        data-start-position="{{ $userProgress->video_position }}"
                                    @endif
                                >
                                    <source src="{{ Storage::url($lesson->video_file) }}" type="video/mp4">
                                    Twoja przeglądarka nie obsługuje odtwarzania wideo.
                                </video>
                                
                                <!-- Video Navigation Controls -->
                                <div class="mt-4 flex items-center justify-between video-navigation-controls p-4 rounded-lg border-2 border-red-500 bg-yellow-100">
                                    <!-- Debug Info -->
                                    <div class="text-xs text-red-600 mb-2 w-full">
                                        DEBUG: previousLesson={{ $previousLesson ? 'EXISTS' : 'NULL' }}, 
                                        nextLesson={{ $nextLesson ? 'EXISTS' : 'NULL' }}, 
                                        video_file={{ $lesson->video_file ? 'EXISTS' : 'NULL' }}
                                    </div>
                                    
                                    <div class="flex items-center space-x-4">
                                        @if($previousLesson)
                                            <a href="{{ route('courses.lesson', ['course' => $course, 'lesson' => $previousLesson]) }}" 
                                               class="flex items-center text-blue-600 hover:text-blue-800 transition duration-300">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                </svg>
                                                <span class="font-medium">Poprzednia lekcja</span>
                                                <span class="lesson-title text-sm text-gray-500 ml-2">{{ $previousLesson->title }}</span>
                                            </a>
                                        @else
                                            <span class="text-gray-400">Brak poprzedniej lekcji</span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center space-x-4">
                                        @if($nextLesson)
                                            <a href="{{ route('courses.lesson', ['course' => $course, 'lesson' => $nextLesson]) }}" 
                                               class="flex items-center text-blue-600 hover:text-blue-800 transition duration-300">
                                                <span class="font-medium">Następna lekcja</span>
                                                <span class="lesson-title text-sm text-gray-500 mr-2">{{ $nextLesson->title }}</span>
                                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        @else
                                            <span class="text-gray-400">Brak następnej lekcji</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($lesson->video_url)
                            <div class="aspect-w-16 aspect-h-9">
                                <iframe src="{{ $lesson->video_url }}" 
                                        class="w-full h-64 rounded-lg" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Content Section -->
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Treść lekcji</h3>
                    <div class="prose max-w-none">
                        {!! $lesson->content !!}
                    </div>
                </div>
            </div>

            <!-- Lesson Actions -->
            <div class="lesson-actions bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        @if($previousLesson)
                            <a href="{{ route('courses.lesson', ['course' => $course, 'lesson' => $previousLesson]) }}" 
                               class="flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Poprzednia lekcja
                            </a>
                        @endif
                        
                        @if($nextLesson)
                            <a href="{{ route('courses.lesson', ['course' => $course, 'lesson' => $nextLesson]) }}" 
                               class="flex items-center text-blue-600 hover:text-blue-800">
                                Następna lekcja
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('courses.show', $course) }}" class="text-gray-600 hover:text-gray-800">
                            Powrót do kursu
                        </a>
                        
                        @if(!$userProgress || !$userProgress->is_completed)
                            <button id="completeLessonBtn" 
                                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition duration-300">
                                Ukończ lekcję
                            </button>
                        @else
                            <span class="text-green-600 font-medium">Lekcja ukończona</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <style>
        /* Video Navigation Controls Styles */
        .video-navigation-controls {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .video-navigation-controls a {
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 8px;
        }
        
        .video-navigation-controls a:hover {
            background: rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }
        
        .video-navigation-controls .lesson-title {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        @media (max-width: 768px) {
            .video-navigation-controls {
                flex-direction: column;
                gap: 1rem;
            }
            
            .video-navigation-controls .lesson-title {
                max-width: 150px;
            }
        }
    </style>
    
    <script>
        // Initialize video controls
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, looking for video...');
            const video = document.getElementById('lesson-video');
            console.log('Video element found:', !!video);
            
            if (video) {
                console.log('Video found, initializing custom controls...');
                console.log('Video source:', video.querySelector('source')?.src);
                console.log('Video readyState:', video.readyState);
                
                // Wait for video to be ready
                if (video.readyState >= 2) {
                    console.log('Video ready, initializing controls...');
                    if (typeof window.initCustomVideoControls === 'function') {
                        initCustomVideoControls(video);
                    } else {
                        console.log('Custom controls not available, using default controls');
                        video.controls = true;
                    }
                } else {
                    console.log('Video not ready, waiting for loadedmetadata...');
                    video.addEventListener('loadedmetadata', function() {
                        console.log('Video metadata loaded, initializing controls...');
                        if (typeof window.initCustomVideoControls === 'function') {
                            initCustomVideoControls(video);
                        } else {
                            console.log('Custom controls not available, using default controls');
                            video.controls = true;
                        }
                    });
                }
                
                // Auto-complete lesson when video ends
                video.addEventListener('ended', function() {
                    console.log('Video ended, auto-completing lesson...');
                    completeLessonAutomatically();
                });
                
                // Fallback: if custom controls fail, ensure basic controls work
                video.addEventListener('error', function(e) {
                    console.error('Video error:', e);
                    console.error('Video error details:', video.error);
                    // Ensure basic controls are available
                    video.controls = true;
                });
            } else {
                console.log('No video element found');
            }
        });
        
        // Function to automatically complete lesson
        function completeLessonAutomatically() {
            const completeBtn = document.getElementById('completeLessonBtn');
            if (completeBtn && !completeBtn.disabled) {
                // Show success message
                showVideoCompletionMessage();
                
                // Complete the lesson directly via API instead of clicking button
                fetch('{{ route("courses.complete-lesson", ["course" => $course, "lesson" => $lesson]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Notify parent window to refresh lessons status
                        if (window.parent && window.parent !== window && typeof window.parent.refreshLessonsAccessibility === 'function') {
                            window.parent.refreshLessonsAccessibility();
                        }
                        
                        // Update navigation buttons
                        console.log('About to call updateNavigationButtons');
                        updateNavigationButtons();
                        
                        // Update the complete button
                        completeBtn.style.display = 'none';
                        const completedSpan = document.createElement('span');
                        completedSpan.className = 'text-green-600 font-medium';
                        completedSpan.textContent = 'Lekcja ukończona';
                        completeBtn.parentNode.insertBefore(completedSpan, completeBtn);
                    }
                })
                .catch(error => {
                    console.error('Error completing lesson automatically:', error);
                });
            }
        }
        
        // Function to show video completion message
        function showVideoCompletionMessage() {
            // Create and show completion notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Wideo zakończone! Automatycznie ukończam lekcję...</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        document.getElementById('completeLessonBtn')?.addEventListener('click', function() {
            if (confirm('Czy na pewno chcesz oznaczyć tę lekcję jako ukończoną?')) {
                fetch('{{ route("courses.complete-lesson", ["course" => $course, "lesson" => $lesson]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Notify parent window to refresh lessons status if this lesson is loaded in iframe
                        if (window.parent && window.parent !== window && typeof window.parent.refreshLessonsAccessibility === 'function') {
                            window.parent.refreshLessonsAccessibility();
                        }
                        
                        // Update navigation buttons
                        console.log('About to call updateNavigationButtons');
                        updateNavigationButtons();
                        
                        // Update the complete button
                        const completeBtn = document.getElementById('completeLessonBtn');
                        if (completeBtn) {
                            completeBtn.style.display = 'none';
                            const completedSpan = document.createElement('span');
                            completedSpan.className = 'text-green-600 font-medium';
                            completedSpan.textContent = 'Lekcja ukończona';
                            completeBtn.parentNode.insertBefore(completedSpan, completeBtn);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Wystąpił błąd podczas ukończenia lekcji.');
                });
            }
        });
        
        // Function to update navigation buttons after lesson completion
        function updateNavigationButtons() {
            console.log('updateNavigationButtons called');
            fetch('{{ route("courses.lesson-navigation", ["course" => $course, "lesson" => $lesson]) }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Navigation response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Navigation data received:', data);
                if (data.success) {
                    const navigationContainer = document.querySelector('.lesson-actions .flex.items-center.space-x-4');
                    console.log('Navigation container found:', !!navigationContainer);
                    
                    if (navigationContainer) {
                        // Clear existing navigation buttons
                        navigationContainer.innerHTML = '';
                        
                        // Add previous lesson button if exists
                        if (data.previous_lesson && data.previous_lesson.is_accessible) {
                            console.log('Adding previous lesson button:', data.previous_lesson);
                            const prevButton = document.createElement('a');
                            prevButton.href = data.previous_lesson.url;
                            prevButton.className = 'flex items-center text-blue-600 hover:text-blue-800';
                            prevButton.innerHTML = `
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Poprzednia lekcja
                            `;
                            navigationContainer.appendChild(prevButton);
                        } else {
                            console.log('Previous lesson not available or not accessible:', data.previous_lesson);
                        }
                        
                        // Add next lesson button if exists and is accessible
                        if (data.next_lesson && data.next_lesson.is_accessible) {
                            console.log('Adding next lesson button:', data.next_lesson);
                            const nextButton = document.createElement('a');
                            nextButton.href = data.next_lesson.url;
                            nextButton.className = 'flex items-center text-blue-600 hover:text-blue-800';
                            nextButton.innerHTML = `
                                Następna lekcja
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            `;
                            navigationContainer.appendChild(nextButton);
                        } else {
                            console.log('Next lesson not available or not accessible:', data.next_lesson);
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error updating navigation buttons:', error);
            });
        }
    </script>
    @endpush
</x-app-layout>
