@extends('layouts.app')

@section('content')
<style>
    .form-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        margin-top: 2rem;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-section {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-section h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
    }

    .form-button {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-button.primary {
        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        color: white !important;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .form-button.primary:hover {
        background: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        color: white !important;
    }

    .form-button.secondary {
        background: linear-gradient(135deg, #6B7280 0%, #4B5563 100%);
        color: white !important;
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
    }

    .form-button.secondary:hover {
        background: linear-gradient(135deg, #4B5563 0%, #374151 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
        color: white !important;
    }

    .form-input {
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        padding: 0.75rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
    }

    .form-input:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
        background: white;
    }

    .form-label {
        color: #374151;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-help-text {
        color: #6B7280;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-error {
        color: #DC2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="form-container">
            <h2 class="form-title">Dodaj Nowy Kurs</h2>
            
            <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block form-label">Tytuł kursu</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full form-input">
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block form-label">Opis kursu</label>
                        <textarea name="description" id="description" rows="4" required
                            class="mt-1 block w-full form-input">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block form-label">Miniaturka kursu</label>
                        <div class="mt-1 flex items-center space-x-4">
                            <div class="flex-1">
                                <input type="file" name="image" id="image" accept="image/*" 
                                    class="mt-1 block w-full form-input p-2" 
                                    onchange="previewImage(this)">
                                <p class="form-help-text">Akceptowane formaty: JPG, PNG, GIF. Maksymalny rozmiar: 2MB</p>
                            </div>
                            <div id="imagePreview" class="hidden">
                                <img id="previewImg" src="" alt="Podgląd" class="w-20 h-20 object-cover rounded-lg border-2 border-gray-200">
                                <button type="button" onclick="removeImage()" class="mt-1 text-red-600 text-sm hover:text-red-800">
                                    Usuń
                                </button>
                            </div>
                        </div>
                        @error('image')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration_minutes" class="block form-label">Czas trwania (minuty)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes') }}" min="1" required
                            class="mt-1 block w-full form-input">
                        @error('duration_minutes')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Points for different user types -->
                    <div class="form-section">
                        <h3>Punkty dla różnych grup użytkowników</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="pharmacist_points" class="block form-label">Punkty dla farmaceutów</label>
                                <input type="number" name="pharmacist_points" id="pharmacist_points" value="{{ old('pharmacist_points', 0) }}" min="0"
                                    class="mt-1 block w-full form-input">
                                <p class="form-help-text">Liczba punktów przyznawanych farmaceutom po ukończeniu kursu</p>
                                @error('pharmacist_points')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="technician_points" class="block form-label">Punkty dla techników farmacji</label>
                                <input type="number" name="technician_points" id="technician_points" value="{{ old('technician_points', 0) }}" min="0"
                                    class="mt-1 block w-full form-input">
                                <p class="form-help-text">Liczba punktów przyznawanych technikom farmacji po ukończeniu kursu</p>
                                @error('technician_points')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Course Settings -->
                    <div class="form-section">
                        <h3>Ustawienia kursu</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block form-label">
                                    Kurs aktywny
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="requires_sequential_lessons" id="requires_sequential_lessons" value="1" {{ old('requires_sequential_lessons') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="requires_sequential_lessons" class="ml-2 block form-label">
                                    Wymaga sekwencyjnego przechodzenia lekcji
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Instruction Settings -->
                    <div class="form-section">
                        <h3 class="section-title">Instrukcja kursu</h3>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="has_instruction" id="has_instruction" value="1" {{ old('has_instruction') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    onchange="toggleInstructionContent()">
                                <label for="has_instruction" class="ml-2 block text-sm text-gray-900">
                                    Kurs ma instrukcję
                                </label>
                            </div>

                            <div id="instruction_content_section" class="{{ old('has_instruction') ? '' : 'hidden' }}">
                                <label for="instruction_content" class="block form-label">Treść instrukcji</label>
                                <textarea name="instruction_content" id="instruction_content" rows="8" placeholder="Wprowadź treść instrukcji kursu, która zostanie wyświetlona w modalu..."
                                    class="form-input mt-1 block w-full">{{ old('instruction_content') }}</textarea>
                                <p class="form-help-text">Treść instrukcji wyświetlana w modalu po kliknięciu przycisku "Instrukcja". Obsługuje podstawowe formatowanie HTML.</p>
                                @error('instruction_content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Certificate Settings -->
                    <div class="form-section">
                        <h3 class="section-title">Ustawienia certyfikatu</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="certificate_header" class="block form-label">Nagłówek certyfikatu</label>
                                <textarea name="certificate_header" id="certificate_header" rows="3" placeholder="Opcjonalny niestandardowy nagłówek certyfikatu. Jeśli puste, zostanie użyty domyślny."
                                    class="mt-1 block w-full form-input">{{ old('certificate_header') }}</textarea>
                                <p class="form-help-text">Niestandardowy nagłówek wyświetlany na górze certyfikatu. Zostaw puste aby użyć domyślnego.</p>
                                @error('certificate_header')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="certificate_footer" class="block form-label">Stopka certyfikatu</label>
                                <textarea name="certificate_footer" id="certificate_footer" rows="3" placeholder="Opcjonalna niestandardowa stopka certyfikatu. Jeśli puste, zostaną użyte domyślne podpisy."
                                    class="mt-1 block w-full form-input">{{ old('certificate_footer') }}</textarea>
                                <p class="form-help-text">Niestandardowa stopka wyświetlana na dole certyfikatu. Zostaw puste aby użyć domyślnych podpisów.</p>
                                @error('certificate_footer')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.courses') }}" class="form-button secondary">
                            Anuluj
                        </a>
                        <button type="submit" class="form-button primary">
                            Utwórz kurs
                        </button>
                    </div>
                </div>
            </form>
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
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('previewImg').src = '';
}

function toggleInstructionContent() {
    const checkbox = document.getElementById('has_instruction');
    const contentSection = document.getElementById('instruction_content_section');

    if (checkbox.checked) {
        contentSection.classList.remove('hidden');
    } else {
        contentSection.classList.add('hidden');
    }
}
</script>
@endsection
