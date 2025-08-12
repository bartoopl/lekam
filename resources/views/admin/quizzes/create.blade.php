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
        background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        color: white !important;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
    }

    .form-button.primary:hover {
        background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
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
        border-color: #8B5CF6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
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

    .course-info {
        background: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
</style>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Course Info -->
        <div class="course-info">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tworzenie testu dla kursu:</h3>
            <h2 class="text-2xl font-bold text-purple-600">{{ $course->title }}</h2>
            <p class="text-gray-600 mt-1">{{ Str::limit($course->description, 150) }}</p>
        </div>

        <div class="form-container">
            <h2 class="form-title">Dodaj Nowy Test Końcowy</h2>
            
            <form action="{{ route('admin.quizzes.store', $course) }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block form-label">Tytuł testu</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full form-input" placeholder="np. Test końcowy - Podstawy farmacji">
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block form-label">Opis testu (opcjonalnie)</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full form-input" placeholder="Krótki opis tego, czego dotyczy test">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Time Limit and Passing Score -->
                    <div class="form-section">
                        <h3>Ustawienia testu</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="time_limit_minutes" class="block form-label">Limit czasu (minuty)</label>
                                <input type="number" name="time_limit_minutes" id="time_limit_minutes" value="{{ old('time_limit_minutes', 30) }}" min="1" max="480" required
                                    class="mt-1 block w-full form-input">
                                <p class="form-help-text">Maksymalny czas na rozwiązanie testu (1-480 min)</p>
                                @error('time_limit_minutes')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="passing_score" class="block form-label">Próg zaliczenia (%)</label>
                                <input type="number" name="passing_score" id="passing_score" value="{{ old('passing_score', 70) }}" min="1" max="100" required
                                    class="mt-1 block w-full form-input">
                                <p class="form-help-text">Minimalny procent poprawnych odpowiedzi do zaliczenia</p>
                                @error('passing_score')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Settings -->
                    <div class="form-section">
                        <h3>Status testu</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block form-label">
                                    Test aktywny
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.courses.show', $course) }}" class="form-button secondary">
                            Anuluj
                        </a>
                        <button type="submit" class="form-button primary">
                            Utwórz test
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
