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
            <div class="bg-white rounded-lg shadow-sm p-6">
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
    <script>
        // Initialize video controls
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('lesson-video');
            if (video) {
                initCustomVideoControls(video);
            }
        });

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
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Wystąpił błąd podczas ukończenia lekcji.');
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
