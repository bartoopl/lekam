<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->title }} - Test
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Próba #{{ $attempt->id }}</span>
                @if($quiz->time_limit_minutes)
                    <div id="timer" class="text-sm font-medium text-red-600"></div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form id="quizForm" method="POST" action="{{ route('quizzes.submit', ['course' => $course, 'attempt' => $attempt]) }}">
                @csrf
                
                <!-- Progress Bar -->
                <div class="bg-white rounded-lg shadow-sm mb-6">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Postęp</span>
                            <span id="progressText" class="text-sm font-medium">0/{{ $questions->count() }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <!-- Questions -->
                <div class="space-y-6">
                    @foreach($questions as $index => $question)
                        <div class="bg-white rounded-lg shadow-sm p-6 question-container" data-question="{{ $index + 1 }}">
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-gray-500">Pytanie {{ $index + 1 }} z {{ $questions->count() }}</span>
                                    <span class="text-sm text-gray-500">{{ $question->points }} punktów</span>
                                </div>
                                <h3 class="text-lg font-medium">{{ $question->question }}</h3>
                            </div>

                            <div class="space-y-3">
                                @if($question->type === 'single_choice')
                                    @foreach($question->options as $option)
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="radio" 
                                                   name="answers[{{ $question->id }}]" 
                                                   value="{{ $option }}" 
                                                   class="mr-3 text-blue-600 focus:ring-blue-500"
                                                   onchange="updateProgress()">
                                            <span>{{ $option }}</span>
                                        </label>
                                    @endforeach
                                @elseif($question->type === 'multiple_choice')
                                    @foreach($question->options as $option)
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="checkbox" 
                                                   name="answers[{{ $question->id }}][]" 
                                                   value="{{ $option }}" 
                                                   class="mr-3 text-blue-600 focus:ring-blue-500"
                                                   onchange="updateProgress()">
                                            <span>{{ $option }}</span>
                                        </label>
                                    @endforeach
                                @elseif($question->type === 'true_false')
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" 
                                               name="answers[{{ $question->id }}]" 
                                               value="true" 
                                               class="mr-3 text-blue-600 focus:ring-blue-500"
                                               onchange="updateProgress()">
                                        <span>Prawda</span>
                                    </label>
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" 
                                               name="answers[{{ $question->id }}]" 
                                               value="false" 
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
                <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Upewnij się, że odpowiedziałeś na wszystkie pytania przed zakończeniem testu.
                        </div>
                        <button type="submit" 
                                id="submitBtn"
                                class="btn btn-success">
                            Zakończ test
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let answeredQuestions = 0;
        const totalQuestions = {{ $questions->count() }};
        
        @if($quiz->time_limit_minutes)
            let timeLeft = {{ $quiz->time_limit_minutes * 60 }};
            const timerElement = document.getElementById('timer');
            
            function updateTimer() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                
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
            if (answeredQuestions < totalQuestions) {
                if (!confirm(`Odpowiedziałeś na ${answeredQuestions} z ${totalQuestions} pytań. Czy na pewno chcesz zakończyć test?`)) {
                    e.preventDefault();
                    return;
                }
            }
            
            if (confirm('Czy na pewno chcesz zakończyć test? Nie będziesz mógł go edytować.')) {
                this.disabled = true;
                this.textContent = 'Przetwarzanie...';
            } else {
                e.preventDefault();
            }
        });
        
        // Initial progress update
        updateProgress();
    </script>
    @endpush
</x-app-layout>
