@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj Nową Lekcję') }} - {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.lessons.store', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Chapter -->
                            <div>
                                <label for="chapter_id" class="block text-sm font-medium text-gray-700">Sekcja *</label>
                                <select name="chapter_id" id="chapter_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Wybierz sekcję</option>
                                    @foreach($course->chapters->sortBy('order') as $chapter)
                                        <option value="{{ $chapter->id }}" {{ old('chapter_id') == $chapter->id ? 'selected' : '' }}>
                                            #{{ $chapter->order }} - {{ $chapter->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($course->chapters->count() == 0)
                                    <p class="mt-1 text-sm text-red-600">Ten kurs nie ma żadnych sekcji. Najpierw dodaj sekcję.</p>
                                @endif
                                @error('chapter_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Instructor -->
                            <div>
                                <label for="instructor_id" class="block text-sm font-medium text-gray-700">Wykładowca</label>
                                <select name="instructor_id" id="instructor_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Wybierz wykładowcę</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->name }} {{ $instructor->specialization ? "({$instructor->specialization})" : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('instructor_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Tytuł lekcji</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700">Treść lekcji</label>
                                <textarea name="content" id="content" rows="8" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Video URL -->
                            <div>
                                <label for="video_url" class="block text-sm font-medium text-gray-700">URL do filmu (opcjonalnie)</label>
                                <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-sm text-gray-500">Lub załaduj plik wideo poniżej</p>
                                @error('video_url')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Video File Upload -->
                            <div>
                                <label for="video_file" class="block text-sm font-medium text-gray-700">Plik wideo (opcjonalnie)</label>
                                <input type="file" name="video_file" id="video_file" accept="video/*"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-sm text-gray-500">Obsługiwane formaty: MP4, AVI, MOV, WMV, FLV, WebM (max 100MB)</p>
                                @error('video_file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if($errors->has('error'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('error') }}</p>
                                @endif
                            </div>

                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Kolejność</label>
                                <input type="number" name="order" id="order" value="{{ old('order', $nextOrder) }}" min="1" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Downloadable Materials Section -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Materiały do pobrania</h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="requires_download_completion" id="requires_download_completion" value="1" {{ old('requires_download_completion') ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="requires_download_completion" class="ml-2 block text-sm text-gray-900">
                                            Wymaga pobrania materiałów
                                        </label>
                                    </div>

                                    <div>
                                        <label for="download_timer_minutes" class="block text-sm font-medium text-gray-700">Timer po pobraniu (minuty)</label>
                                        <input type="number" name="download_timer_minutes" id="download_timer_minutes" value="{{ old('download_timer_minutes', 0) }}" min="0"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <p class="mt-1 text-sm text-gray-500">Czas, który musi upłynąć po pobraniu materiałów przed odblokowaniem kolejnej lekcji</p>
                                    </div>

                                    <div id="materials-container">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Materiały do pobrania</label>
                                        <div id="materials-list" class="space-y-3">
                                            <!-- Materials will be added here dynamically -->
                                        </div>
                                        <button type="button" id="add-material" class="btn btn-success">
                                            + Dodaj materiał
                                        </button>
                                        <p class="mt-1 text-sm text-gray-500">Dozwolone formaty: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT (max 10MB)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Lesson Settings -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Ustawienia lekcji</h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_required" id="is_required" value="1" {{ old('is_required') ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="is_required" class="ml-2 block text-sm text-gray-900">
                                            Lekcja wymagana
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_first_lesson" id="is_first_lesson" value="1" {{ old('is_first_lesson') ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="is_first_lesson" class="ml-2 block text-sm text-gray-900">
                                            Pierwsza lekcja w kursie
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_last_lesson" id="is_last_lesson" value="1" {{ old('is_last_lesson') ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="is_last_lesson" class="ml-2 block text-sm text-gray-900">
                                            Ostatnia lekcja w kursie
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-secondary">
                                    Anuluj
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Utwórz lekcję
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let materialIndex = 0;

        document.getElementById('add-material').addEventListener('click', function() {
            const materialsList = document.getElementById('materials-list');
            const materialDiv = document.createElement('div');
            materialDiv.className = 'border border-gray-200 rounded p-3 bg-gray-50';
            materialDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nazwa materiału</label>
                        <input type="text" name="downloadable_materials[${materialIndex}][name]" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="np. Skrypt wykładu, Materiały pomocnicze">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Plik</label>
                        <input type="file" name="downloadable_materials[${materialIndex}][file]" required
                            accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            onchange="validateFile(this)">
                        <div class="file-info mt-1 text-xs text-gray-500"></div>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-xs text-gray-500">Materiał #${materialIndex + 1}</span>
                    <button type="button" class="text-red-600 hover:text-red-900 text-sm" onclick="this.closest('.border').remove()">
                        🗑️ Usuń materiał
                    </button>
                </div>
            `;
            materialsList.appendChild(materialDiv);
            materialIndex++;
        });

        function validateFile(input) {
            const file = input.files[0];
            const fileInfo = input.parentElement.querySelector('.file-info');
            const maxSize = 10 * 1024 * 1024; // 10MB
            
            if (file) {
                // Check file size
                if (file.size > maxSize) {
                    fileInfo.innerHTML = `<span class="text-red-600">❌ Plik za duży (max 10MB)</span>`;
                    input.value = '';
                    return;
                }
                
                // Check file type
                const allowedTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'text/plain'
                ];
                
                if (!allowedTypes.includes(file.type)) {
                    fileInfo.innerHTML = `<span class="text-red-600">❌ Nieobsługiwany format pliku</span>`;
                    input.value = '';
                    return;
                }
                
                // Show file info
                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                fileInfo.innerHTML = `<span class="text-green-600">✅ ${file.name} (${sizeInMB} MB)</span>`;
            }
        }

        // Add first material by default
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('add-material').click();
        });
    </script>
@endsection
