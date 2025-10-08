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
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white !important;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .form-button.primary:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
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
        border-color: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
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

    .quiz-info {
        background: linear-gradient(135deg, #E0E7FF 0%, #C7D2FE 100%);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .option-item {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.75rem;
    }

    .option-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .option-number {
        background: #10B981;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .btn-remove-option {
        background: #EF4444;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-remove-option:hover {
        background: #DC2626;
    }

    .btn-add-option {
        background: #10B981;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .btn-add-option:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .correct-answer-section {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .correct-answer-section h4 {
        color: #059669;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
</style>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Course Info -->
        <div class="course-info">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Edycja pytania dla kursu:</h3>
            <h2 class="text-2xl font-bold text-gray-700">{{ $course->title }}</h2>
            <p class="text-gray-600 mt-1">{{ Str::limit($course->description, 150) }}</p>
        </div>

        <!-- Quiz Info -->
        <div class="quiz-info">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Test:</h3>
            <h2 class="text-xl font-bold text-purple-600">{{ $quiz->title }}</h2>
            @if($quiz->description)
                <p class="text-gray-600 mt-1">{{ $quiz->description }}</p>
            @endif
        </div>

        <div class="form-container">
            <h2 class="form-title">Edytuj Pytanie</h2>

            <form action="{{ route('admin.questions.update', [$course, $quiz, $question]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Question Text -->
                    <div>
                        <label for="question" class="block form-label">Treść pytania</label>
                        <textarea name="question" id="question" rows="4" required
                            class="mt-1 block w-full form-input" placeholder="Wpisz treść pytania...">{{ old('question', $question->question) }}</textarea>
                        @error('question')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Question Type -->
                    <div class="form-section">
                        <h3>Typ pytania</h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="radio" name="type" id="type_single" value="single_choice"
                                    {{ old('type', $question->type) === 'single_choice' ? 'checked' : '' }} required
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="type_single" class="ml-2 block form-label">
                                    Jednokrotny wybór
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="type" id="type_multiple" value="multiple_choice"
                                    {{ old('type', $question->type) === 'multiple_choice' ? 'checked' : '' }}
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="type_multiple" class="ml-2 block form-label">
                                    Wielokrotny wybór
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="type" id="type_true_false" value="true_false"
                                    {{ old('type', $question->type) === 'true_false' ? 'checked' : '' }}
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="type_true_false" class="ml-2 block form-label">
                                    Prawda/Fałsz
                                </label>
                            </div>
                        </div>
                        @error('type')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options Section (for single/multiple choice) -->
                    <div id="optionsSection" class="form-section hidden">
                        <h3>Opcje odpowiedzi</h3>
                        <p class="form-help-text mb-4">Dodaj co najmniej 2 opcje odpowiedzi. Zaznacz które są poprawne.</p>
                        
                        <div id="optionsContainer">
                            <!-- Options will be added here dynamically -->
                        </div>
                        
                        <button type="button" id="addOptionBtn" class="btn btn-success">
                            ➕ Dodaj opcję
                        </button>
                        
                        @error('options')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                        @error('correct_answers')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- True/False Section -->
                    <div id="trueFalseSection" class="form-section hidden">
                        <h3>Poprawna odpowiedź</h3>
                        <p class="form-help-text mb-4">Wybierz poprawną odpowiedź dla pytania prawda/fałsz.</p>
                        
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="radio" name="correct_answers[]" id="correct_true" value="true"
                                    {{ (old('correct_answers') ? in_array('true', old('correct_answers', [])) : ($question->correct_answers[0] ?? false) === true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="correct_true" class="ml-2 block form-label">
                                    Prawda
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="correct_answers[]" id="correct_false" value="false"
                                    {{ (old('correct_answers') ? in_array('false', old('correct_answers', [])) : ($question->correct_answers[0] ?? false) === false) ? 'checked' : '' }}
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="correct_false" class="ml-2 block form-label">
                                    Fałsz
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Points and Order -->
                    <div class="form-section">
                        <h3>Ustawienia pytania</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="points" class="block form-label">Punkty za pytanie</label>
                                <input type="number" name="points" id="points" value="{{ old('points', $question->points) }}" min="1" max="100" required
                                    class="mt-1 block w-full form-input">
                                <p class="form-help-text">Liczba punktów za poprawną odpowiedź (1-100)</p>
                                @error('points')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="order" class="block form-label">Kolejność (opcjonalnie)</label>
                                <input type="number" name="order" id="order" value="{{ old('order', $question->order) }}" min="1"
                                    class="mt-1 block w-full form-input" placeholder="Automatyczna">
                                <p class="form-help-text">Kolejność pytania w teście (puste = na końcu)</p>
                                @error('order')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.quizzes.edit', [$course, $quiz]) }}" class="form-button secondary">
                            Anuluj
                        </a>
                        <button type="submit" class="form-button primary">
                            Zapisz zmiany
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let optionCounter = 0;

function showOptionsSection() {
    const type = document.querySelector('input[name="type"]:checked').value;
    const optionsSection = document.getElementById('optionsSection');
    const trueFalseSection = document.getElementById('trueFalseSection');
    
    if (type === 'single_choice' || type === 'multiple_choice') {
        optionsSection.classList.remove('hidden');
        trueFalseSection.classList.add('hidden');
        
        // Initialize with 2 options if none exist
        if (document.querySelectorAll('.option-item').length === 0) {
            addOption();
            addOption();
        }
    } else if (type === 'true_false') {
        optionsSection.classList.add('hidden');
        trueFalseSection.classList.remove('hidden');
    }
}

function addOption() {
    optionCounter++;
    const container = document.getElementById('optionsContainer');
    const optionDiv = document.createElement('div');
    optionDiv.className = 'option-item';
    
    const inputType = document.querySelector('input[name="type"]:checked').value === 'single_choice' ? 'radio' : 'checkbox';
    
    optionDiv.innerHTML = `
        <div class="option-header">
            <span class="option-number">Opcja ${optionCounter}</span>
            <button type="button" class="btn btn-danger" onclick="removeOption(this)">Usuń</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block form-label">Tekst opcji</label>
                <input type="text" name="options[]" required maxlength="255"
                    class="mt-1 block w-full form-input" placeholder="Wpisz tekst opcji...">
            </div>
            <div class="flex items-center space-x-2">
                <input type="${inputType}" name="correct_answers[]" value="${optionCounter - 1}" 
                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                <label class="form-label">Poprawna odpowiedź</label>
            </div>
        </div>
    `;
    
    container.appendChild(optionDiv);
}

function removeOption(button) {
    button.closest('.option-item').remove();
    updateOptionNumbers();
}

function updateOptionNumbers() {
    const options = document.querySelectorAll('.option-item');
    options.forEach((option, index) => {
        const numberSpan = option.querySelector('.option-number');
        numberSpan.textContent = `Opcja ${index + 1}`;
        
        const correctAnswerInput = option.querySelector('input[name="correct_answers[]"]');
        correctAnswerInput.value = index;
    });
    optionCounter = options.length;
}

// Load existing options for editing
function loadExistingOptions() {
    const questionType = '{{ $question->type }}';
    const options = @json($question->options ?? []);
    const correctAnswers = @json($question->correct_answers ?? []);

    if (questionType === 'single_choice' || questionType === 'multiple_choice') {
        const container = document.getElementById('optionsContainer');
        const inputType = questionType === 'single_choice' ? 'radio' : 'checkbox';

        options.forEach((option, index) => {
            optionCounter++;
            const optionDiv = document.createElement('div');
            optionDiv.className = 'option-item';

            const isCorrect = correctAnswers.includes(index);

            optionDiv.innerHTML = `
                <div class="option-header">
                    <span class="option-number">Opcja ${optionCounter}</span>
                    <button type="button" class="btn btn-danger" onclick="removeOption(this)">Usuń</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block form-label">Tekst opcji</label>
                        <input type="text" name="options[]" required maxlength="255"
                            class="mt-1 block w-full form-input" placeholder="Wpisz tekst opcji..." value="${option}">
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="${inputType}" name="correct_answers[]" value="${index}"
                            ${isCorrect ? 'checked' : ''}
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                        <label class="form-label">Poprawna odpowiedź</label>
                    </div>
                </div>
            `;

            container.appendChild(optionDiv);
        });
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const typeInputs = document.querySelectorAll('input[name="type"]');
    typeInputs.forEach(input => {
        input.addEventListener('change', showOptionsSection);
    });

    const addOptionBtn = document.getElementById('addOptionBtn');
    if (addOptionBtn) {
        addOptionBtn.addEventListener('click', addOption);
    }

    // Load existing options first
    loadExistingOptions();

    // Show appropriate section based on initial value
    const initialType = document.querySelector('input[name="type"]:checked');
    if (initialType) {
        showOptionsSection();
    }
});
</script>
@endsection
