<div class="lesson-header">
    <div class="flex items-center justify-between mb-4">
        <h2 class="lesson-title-main">{{ $quiz->title }}</h2>
        @if($quiz->time_limit_minutes)
            <div id="timer" class="text-lg font-semibold text-red-600 bg-red-50 px-4 py-2 rounded-lg"></div>
        @endif
    </div>
    <div class="lesson-description">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-600">Próba #{{ $attempt->id }}</span>
            <span id="progressText" class="text-sm font-medium">0/{{ $questions->count() }}</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>
</div>

<form id="quizForm" method="POST" action="{{ route('quizzes.submit', ['course' => $course, 'attempt' => $attempt]) }}">
    @csrf
    
    <!-- Questions -->
    <div class="space-y-6 mb-8">
        @foreach($questions as $index => $question)
            <div class="bg-gray-50 rounded-lg p-6 question-container" data-question="{{ $index + 1 }}">
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-500">Pytanie {{ $index + 1 }} z {{ $questions->count() }}</span>
                        <span class="text-sm text-gray-500">{{ $question->points }} punktów</span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800">{{ $question->question }}</h3>
                </div>

                <div class="space-y-3">
                    @if($question->type === 'single_choice')
                        @foreach($question->options as $index => $option)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition-colors">
                                <input type="radio" 
                                       name="answers[{{ $question->id }}]" 
                                       value="{{ $index }}" 
                                       class="mr-3 text-blue-600 focus:ring-blue-500"
                                       onchange="updateProgress()">
                                <span>{{ $option }}</span>
                            </label>
                        @endforeach
                    @elseif($question->type === 'multiple_choice')
                        @foreach($question->options as $index => $option)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition-colors">
                                <input type="checkbox" 
                                       name="answers[{{ $question->id }}][]" 
                                       value="{{ $index }}" 
                                       class="mr-3 text-blue-600 focus:ring-blue-500"
                                       onchange="updateProgress()">
                                <span>{{ $option }}</span>
                            </label>
                        @endforeach
                    @elseif($question->type === 'true_false')
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="answers[{{ $question->id }}]" 
                                   value="0" 
                                   class="mr-3 text-blue-600 focus:ring-blue-500"
                                   onchange="updateProgress()">
                            <span>Prawda</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="answers[{{ $question->id }}]" 
                                   value="1" 
                                   class="mr-3 text-blue-600 focus:ring-blue-500"
                                   onchange="updateProgress()">
                            <span>Fałsz</span>
                        </label>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Submit Button -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
        <p class="text-yellow-800 mb-4">
            Upewnij się, że odpowiedziałeś na wszystkie pytania przed zakończeniem testu.
        </p>
        <button type="submit" 
                id="submitBtn"
                class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300">
            Zakończ test
        </button>
    </div>
</form>

<style>
    /* Enhanced radio button and checkbox styling */
    input[type="radio"], input[type="checkbox"] {
        width: 20px !important;
        height: 20px !important;
        appearance: none !important;
        border: 2px solid #d1d5db !important;
        border-radius: 50% !important;
        background-color: white !important;
        cursor: pointer !important;
        position: relative !important;
        transition: all 0.2s ease !important;
    }
    
    input[type="checkbox"] {
        border-radius: 4px !important;
    }
    
    input[type="radio"]:checked, input[type="checkbox"]:checked {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
    }
    
    input[type="radio"]:checked::after {
        content: '' !important;
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 50% !important;
        background-color: white !important;
        display: block !important;
    }
    
    input[type="checkbox"]:checked::after {
        content: '✓' !important;
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        color: white !important;
        font-size: 14px !important;
        font-weight: bold !important;
        line-height: 1 !important;
    }
    
    input[type="radio"]:hover, input[type="checkbox"]:hover {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    }
    
    /* Enhanced label styling */
    label:has(input:checked) {
        background-color: #eff6ff !important;
        border-color: #3b82f6 !important;
        color: #1e40af !important;
    }
</style>

<script>
    let answeredQuestions = 0;
    const totalQuestions = {{ $questions->count() }};
    
    @if($quiz->time_limit_minutes)
        let timeLeft = {{ $quiz->time_limit_minutes * 60 }};
        const timerElement = document.getElementById('timer');
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `Czas: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                alert('Czas na test wygasł!');
                document.getElementById('quizForm').submit();
            } else {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
        }
        
        updateTimer();
    @endif
    
    function updateProgress() {
        answeredQuestions = 0;
        const questions = document.querySelectorAll('.question-container');
        
        questions.forEach(question => {
            const inputs = question.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked');
            if (inputs.length > 0) {
                answeredQuestions++;
            }
        });
        
        const progressPercentage = (answeredQuestions / totalQuestions) * 100;
        document.getElementById('progressBar').style.width = progressPercentage + '%';
        document.getElementById('progressText').textContent = `${answeredQuestions}/${totalQuestions}`;
    }
    
    document.getElementById('submitBtn').addEventListener('click', function(e) {
        e.preventDefault();
        
        if (answeredQuestions < totalQuestions) {
            if (!confirm(`Odpowiedziałeś na ${answeredQuestions} z ${totalQuestions} pytań. Czy na pewno chcesz zakończyć test?`)) {
                return;
            }
        }
        
        if (confirm('Czy na pewno chcesz zakończyć test? Nie będziesz mógł go edytować.')) {
            this.disabled = true;
            this.textContent = 'Przetwarzanie...';
            
            // Use regular form submit instead of AJAX
            document.getElementById('quizForm').submit();
        }
    });
    
    // Initial progress update
    updateProgress();
</script>