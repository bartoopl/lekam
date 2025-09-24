@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edytuj Kurs') }}: {{ $course->title }}
                </h2>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Tytuł kursu</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Opis kursu</label>
                                <textarea name="description" id="description" rows="4" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $course->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Miniaturka kursu</label>
                                <div class="mt-1 flex items-center space-x-4">
                                    <div class="flex-1">
                                        <input type="file" name="image" id="image" accept="image/*" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" 
                                            onchange="previewImage(this)">
                                        <p class="mt-1 text-sm text-gray-500">Akceptowane formaty: JPG, PNG, GIF. Maksymalny rozmiar: 2MB</p>
                                    </div>
                                    <div id="imagePreview" class="{{ $course->image ? '' : 'hidden' }}">
                                        <img id="previewImg" src="{{ $course->image ? asset('storage/' . $course->image) : '' }}" alt="Podgląd" class="w-20 h-20 object-cover rounded-lg border-2 border-gray-200">
                                        <button type="button" onclick="removeImage()" class="mt-1 text-red-600 text-sm hover:text-red-800">
                                            Usuń
                                        </button>
                                    </div>
                                </div>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Czas trwania (minuty)</label>
                                <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', $course->duration_minutes) }}" min="1" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('duration_minutes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Points for different user types -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Punkty dla różnych grup użytkowników</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="pharmacist_points" class="block text-sm font-medium text-gray-700">Punkty dla farmaceutów</label>
                                        <input type="number" name="pharmacist_points" id="pharmacist_points" value="{{ old('pharmacist_points', $course->pharmacist_points) }}" min="0"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <p class="mt-1 text-sm text-gray-500">Liczba punktów przyznawanych farmaceutom po ukończeniu kursu</p>
                                        @error('pharmacist_points')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="technician_points" class="block text-sm font-medium text-gray-700">Punkty dla techników farmacji</label>
                                        <input type="number" name="technician_points" id="technician_points" value="{{ old('technician_points', $course->technician_points) }}" min="0"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <p class="mt-1 text-sm text-gray-500">Liczba punktów przyznawanych technikom farmacji po ukończeniu kursu</p>
                                        @error('technician_points')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Course Settings -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Ustawienia kursu</h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $course->is_active) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                            Kurs aktywny
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" name="requires_sequential_lessons" id="requires_sequential_lessons" value="1" {{ old('requires_sequential_lessons', $course->requires_sequential_lessons) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="requires_sequential_lessons" class="ml-2 block text-sm text-gray-900">
                                            Wymaga sekwencyjnego przechodzenia lekcji
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Certificate Settings -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Ustawienia certyfikatu</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="certificate_header" class="block text-sm font-medium text-gray-700">Nagłówek certyfikatu</label>
                                        <textarea name="certificate_header" id="certificate_header" rows="3" placeholder="Opcjonalny niestandardowy nagłówek certyfikatu. Jeśli puste, zostanie użyty domyślny."
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('certificate_header', $course->certificate_header) }}</textarea>
                                        <p class="mt-1 text-sm text-gray-500">Niestandardowy nagłówek wyświetlany na górze certyfikatu. Zostaw puste aby użyć domyślnego.</p>
                                        @error('certificate_header')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="certificate_footer" class="block text-sm font-medium text-gray-700">Stopka certyfikatu</label>
                                        <textarea name="certificate_footer" id="certificate_footer" rows="3" placeholder="Opcjonalna niestandardowa stopka certyfikatu. Jeśli puste, zostaną użyte domyślne podpisy."
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('certificate_footer', $course->certificate_footer) }}</textarea>
                                        <p class="mt-1 text-sm text-gray-500">Niestandardowa stopka wyświetlana na dole certyfikatu. Zostaw puste aby użyć domyślnych podpisów.</p>
                                        @error('certificate_footer')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-secondary">
                                    Anuluj
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Zaktualizuj kurs
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
function previewImage(input) {
    const file = input.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        // Sprawdź rozmiar pliku (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Plik jest za duży. Maksymalny rozmiar to 2MB.');
            input.value = '';
            return;
        }
        
        // Sprawdź typ pliku
        if (!file.type.startsWith('image/')) {
            alert('Proszę wybrać plik obrazka.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
}

function removeImage() {
    if (confirm('Czy na pewno chcesz usunąć obrazek kursu?')) {
        // Send AJAX request to remove image
        fetch(`{{ route('admin.courses.remove-image', $course) }}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('imagePreview').classList.add('hidden');
                document.getElementById('previewImg').src = '';
                // Show success message
                alert('Obrazek został usunięty pomyślnie.');
            } else {
                alert('Błąd podczas usuwania obrazka: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Wystąpił błąd podczas usuwania obrazka.');
        });
    }
}
</script>
@endsection
