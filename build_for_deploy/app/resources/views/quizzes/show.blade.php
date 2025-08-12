<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }} - Test końcowy
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold mb-4">{{ $quiz->title }}</h1>
                        <p class="text-lg text-gray-600">{{ $quiz->description }}</p>
                    </div>

                    <!-- Quiz Information -->
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-semibold mb-4">Informacje o teście</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Liczba pytań:</span>
                                    <span class="font-medium">{{ $quiz->questions->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Czas limit:</span>
                                    <span class="font-medium">
                                        @if($quiz->time_limit_minutes)
                                            {{ $quiz->time_limit_minutes }} minut
                                        @else
                                            Bez limitu
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Próg zaliczenia:</span>
                                    <span class="font-medium">{{ $quiz->passing_score }}%</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Maksymalny wynik:</span>
                                    <span class="font-medium">{{ $quiz->getMaxScore() }} punktów</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="font-semibold mb-4">Twoje wyniki</h3>
                            @if($bestAttempt)
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Najlepszy wynik:</span>
                                        <span class="font-medium">{{ $bestAttempt->score }}/{{ $bestAttempt->max_score }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Procent:</span>
                                        <span class="font-medium">{{ $bestAttempt->percentage }}%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium {{ $bestAttempt->passed ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $bestAttempt->passed ? 'Zaliczony' : 'Nie zaliczony' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Data:</span>
                                        <span class="font-medium">{{ $bestAttempt->completed_at ? $bestAttempt->completed_at->format('d.m.Y H:i') : 'Brak danych' }}</span>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-600">Nie masz jeszcze żadnych prób.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                        <h3 class="font-semibold text-yellow-800 mb-3">Instrukcje</h3>
                        <ul class="text-yellow-700 space-y-2">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Upewnij się, że masz stabilne połączenie z internetem
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Nie odświeżaj strony podczas testu
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Odpowiedz na wszystkie pytania przed zakończeniem
                            </li>
                            @if(auth()->user()->isTechnician())
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <span class="text-orange-700 font-medium">Jako technik farmacji otrzymasz 80% punktów za poprawne odpowiedzi</span>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Start Quiz Button -->
                    <div class="text-center">
                        @if($bestAttempt && $bestAttempt->passed)
                            <div class="mb-4">
                                <p class="text-green-600 font-medium">Gratulacje! Test został już zaliczony.</p>
                                <p class="text-gray-600">Możesz ponownie przystąpić do testu, aby poprawić swój wynik.</p>
                            </div>
                        @endif
                        
                        <button id="startQuizBtn" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                            Rozpocznij test
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('startQuizBtn').addEventListener('click', function() {
            if (confirm('Czy na pewno chcesz rozpocząć test? Po rozpoczęciu nie będziesz mógł go przerwać.')) {
                fetch('{{ route("quizzes.start", $course) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect_url;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Wystąpił błąd podczas rozpoczynania testu.');
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
