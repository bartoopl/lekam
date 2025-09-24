@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-sm">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $instructor->name }}
                </h2>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.instructors.edit', $instructor) }}" class="btn btn-primary">
                        Edytuj wykładowcę
                    </a>
                    <a href="{{ route('admin.instructors.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300">
                        Powrót do listy
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Instructor Details -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column - Photo and Basic Info -->
                        <div class="lg:col-span-1">
                            <div class="text-center">
                                <img src="{{ $instructor->photo_url }}" alt="{{ $instructor->name }}"
                                     class="w-48 h-48 rounded-full object-cover mx-auto mb-4">

                                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $instructor->name }}</h1>

                                @if($instructor->email)
                                    <p class="text-gray-600 mb-2">
                                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $instructor->email }}
                                    </p>
                                @endif

                                @if($instructor->specialization)
                                    <p class="text-blue-600 font-medium mb-2">{{ $instructor->specialization }}</p>
                                @endif

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $instructor->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $instructor->is_active ? 'Aktywny' : 'Nieaktywny' }}
                                </span>
                            </div>
                        </div>

                        <!-- Right Column - Bio and Lessons -->
                        <div class="lg:col-span-2">
                            @if($instructor->bio)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Biografia</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $instructor->bio }}</p>
                                </div>
                            @endif

                            <!-- Lessons Section -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    Lekcje ({{ $instructor->lessons->count() }})
                                </h3>

                                @if($instructor->lessons->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($instructor->lessons as $lesson)
                                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                                                <div class="flex items-start justify-between">
                                                    <div>
                                                        <h4 class="font-medium text-gray-900">{{ $lesson->title }}</h4>
                                                        @if($lesson->course)
                                                            <p class="text-sm text-blue-600 mt-1">{{ $lesson->course->title }}</p>
                                                        @endif
                                                        @if($lesson->description)
                                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($lesson->description, 100) }}</p>
                                                        @endif
                                                        <div class="flex items-center mt-2 text-xs text-gray-500">
                                                            @if($lesson->duration)
                                                                <span class="mr-4">{{ $lesson->duration }} min</span>
                                                            @endif
                                                            <span>{{ $lesson->created_at->format('d.m.Y') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        @if($lesson->course)
                                                            <a href="{{ route('admin.lessons.edit', [$lesson->course, $lesson]) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                                Edytuj
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <h4 class="mt-2 text-sm font-medium text-gray-900">Brak lekcji</h4>
                                        <p class="mt-1 text-sm text-gray-500">Ten wykładowca nie ma jeszcze przypisanych lekcji.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <form action="{{ route('admin.instructors.destroy', $instructor) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tego wykładowcę? Ta akcja jest nieodwracalna.')">
                                    Usuń wykładowcę
                                </button>
                            </form>

                            <div class="text-sm text-gray-500">
                                Utworzony: {{ $instructor->created_at->format('d.m.Y H:i') }}
                                @if($instructor->updated_at != $instructor->created_at)
                                    <br>Ostatnia aktualizacja: {{ $instructor->updated_at->format('d.m.Y H:i') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection