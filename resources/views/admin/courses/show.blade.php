@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-sm">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Szczegóły Kursu') }}: {{ $course->title }}
                </h2>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-primary">
                        ✏️ Edytuj kurs
                    </a>
                    <a href="{{ route('admin.chapters.create', $course) }}" class="btn btn-info">
                        📚 Dodaj sekcję
                    </a>
                    <a href="{{ route('admin.lessons.create', $course) }}" class="btn btn-success">
                        ➕ Dodaj lekcję
                    </a>
                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć ten kurs?')">
                            🗑️ Usuń kurs
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Course Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Informacje o kursie</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $course->lessons->count() }}</div>
                            <div class="text-sm text-gray-600">Lekcji</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $course->duration_minutes }}</div>
                            <div class="text-sm text-gray-600">Minut</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">{{ $course->pharmacist_points }}</div>
                            <div class="text-sm text-gray-600">Punkty (Farmaceuci)</div>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-orange-600">{{ $course->technician_points }}</div>
                            <div class="text-sm text-gray-600">Punkty (Technicy)</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Tytuł</div>
                            <div class="text-lg text-gray-900">{{ $course->title }}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($course->is_active) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                {{ $course->is_active ? 'Aktywny' : 'Nieaktywny' }}
                            </span>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Czas trwania</div>
                            <div class="text-lg text-gray-900">{{ $course->duration_minutes }} minut</div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="text-sm font-medium text-gray-500">Opis</div>
                            <div class="text-lg text-gray-900">{{ $course->description }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chapters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Sekcje ({{ $course->chapters->count() }})</h3>
                        <a href="{{ route('admin.chapters.create', $course) }}" class="btn btn-info">
                            ➕ Dodaj sekcję
                        </a>
                    </div>
                    
                    @if($course->chapters->count() > 0)
                        <div class="space-y-4">
                            @foreach($course->chapters->sortBy('order') as $chapter)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-medium text-gray-500">#{{ $chapter->order }}</span>
                                                <h4 class="text-lg font-medium text-gray-900">{{ $chapter->title }}</h4>
                                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">{{ $chapter->lessons->count() }} lekcji</span>
                                            </div>
                                            
                                            @if($chapter->description)
                                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($chapter->description, 100) }}</p>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.chapters.edit', [$course, $chapter]) }}" class="text-blue-600 hover:text-blue-900 text-sm">Edytuj</a>
                                            <form action="{{ route('admin.chapters.destroy', [$course, $chapter]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Czy na pewno chcesz usunąć tę sekcję?')">
                                                    Usuń
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak sekcji</h3>
                            <p class="mt-1 text-sm text-gray-500">Ten kurs nie ma jeszcze żadnych sekcji. Dodaj sekcję, aby móc organizować lekcje.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Lessons -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Lekcje ({{ $course->lessons->count() }})</h3>
                        @if($course->chapters->count() > 0)
                                                    <a href="{{ route('admin.lessons.create', $course) }}" class="btn btn-success">
                            ➕ Dodaj lekcję
                        </a>
                        @else
                            <span class="text-sm text-gray-500">Najpierw dodaj sekcję, aby móc dodać lekcję</span>
                        @endif
                    </div>
                    
                    @if($course->lessons->count() > 0)
                        <div class="space-y-6">
                            @foreach($course->chapters->sortBy('order') as $chapter)
                                <div class="border border-gray-200 rounded-lg">
                                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $chapter->title }}</h4>
                                        @if($chapter->description)
                                            <p class="text-sm text-gray-600 mt-1">{{ $chapter->description }}</p>
                                        @endif
                                    </div>
                                    
                                    @if($chapter->lessons->count() > 0)
                                        <div class="p-4 space-y-3">
                                            @foreach($chapter->lessons->sortBy('order') as $lesson)
                                                <div class="border border-gray-200 rounded-lg p-3 bg-white">
                                                    <div class="flex justify-between items-start">
                                                        <div class="flex-1">
                                                            <div class="flex items-center space-x-2">
                                                                <span class="text-sm font-medium text-gray-500">#{{ $lesson->order }}</span>
                                                                <h5 class="text-md font-medium text-gray-900">{{ $lesson->title }}</h5>
                                                                @if($lesson->is_first_lesson)
                                                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Pierwsza</span>
                                                                @endif
                                                                @if($lesson->is_last_lesson)
                                                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Ostatnia</span>
                                                                @endif
                                                            </div>
                                                            
                                                            @if($lesson->instructor)
                                                                <div class="flex items-center space-x-2 mt-1">
                                                                    <img src="{{ $lesson->instructor->photo_url }}" alt="{{ $lesson->instructor->name }}" 
                                                                         class="w-6 h-6 rounded-full object-cover">
                                                                    <span class="text-sm text-gray-600">{{ $lesson->instructor->name }}</span>
                                                                    @if($lesson->instructor->specialization)
                                                                        <span class="text-xs text-blue-600">({{ $lesson->instructor->specialization }})</span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            
                                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($lesson->content, 100) }}</p>
                                                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                                                @if($lesson->video_url)
                                                                    <span>🎥 Video</span>
                                                                @endif
                                                                @if($lesson->hasDownloadableMaterials())
                                                                    <span>📎 Materiały do pobrania ({{ count($lesson->downloadable_materials) }})</span>
                                                                @endif
                                                                @if($lesson->requires_download_completion)
                                                                    <span>⏱️ Timer: {{ $lesson->download_timer_minutes }} min</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('admin.lessons.edit', [$course, $lesson]) }}" class="text-blue-600 hover:text-blue-900 text-sm">Edytuj</a>
                                                            <form action="{{ route('admin.lessons.destroy', [$course, $lesson]) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Czy na pewno chcesz usunąć tę lekcję?')">
                                                                    Usuń
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="p-4 text-center text-gray-500">
                                            <p>Ta sekcja nie ma jeszcze żadnych lekcji.</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak lekcji</h3>
                            <p class="mt-1 text-sm text-gray-500">Ten kurs nie ma jeszcze żadnych lekcji.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quiz -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Test końcowy</h3>
                        @if($course->quiz)
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.quizzes.edit', [$course, $course->quiz]) }}" class="btn btn-info">
                                    ✏️ Edytuj test
                                </a>
                                <form action="{{ route('admin.quizzes.destroy', [$course, $course->quiz]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć ten test?')">
                                        🗑️ Usuń test
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('admin.quizzes.create', $course) }}" class="btn btn-info">
                                ➕ Dodaj test
                            </a>
                        @endif
                    </div>
                    
                    @if($course->quiz)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-lg font-medium text-gray-900">{{ $course->quiz->title }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $course->quiz->description }}</p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>⏱️ Limit czasu: {{ $course->quiz->time_limit_minutes }} min</span>
                                <span>📊 Próg zaliczenia: {{ $course->quiz->passing_score }}%</span>
                                <span>❓ Pytania: {{ $course->quiz->questions->count() }}</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak testu</h3>
                            <p class="mt-1 text-sm text-gray-500">Ten kurs nie ma jeszcze testu końcowego.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Certificates -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Certyfikaty ({{ $course->certificates->count() }})</h3>
                    
                    @if($course->certificates->count() > 0)
                        <div class="space-y-2">
                            @foreach($course->certificates->take(5) as $certificate)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $certificate->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $certificate->certificate_number }}</div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $certificate->issued_at->format('d.m.Y H:i') }}
                                    </div>
                                </div>
                            @endforeach
                            @if($course->certificates->count() > 5)
                                <div class="text-center py-2">
                                    <span class="text-sm text-gray-500">I {{ $course->certificates->count() - 5 }} więcej...</span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak certyfikatów</h3>
                            <p class="mt-1 text-sm text-gray-500">Nikt jeszcze nie ukończył tego kursu.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
