@extends('layouts.app')

@section('content')
<style>
    html, body {
        background-image: url('/images/backgrounds/bg.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        padding-top: 120px;
    }

    .result-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 3rem;
        margin: 2rem auto;
        max-width: 800px;
        text-align: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    }

    .congratulations-title {
        font-size: 3rem;
        font-weight: 800;
        color: #21235F;
        margin-bottom: 1.5rem;
        font-family: 'Poppins', sans-serif;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .success-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.6);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
    }

    .result-description {
        font-size: 1.2rem;
        line-height: 1.8;
        color: #4B5563;
        margin-bottom: 3rem;
        background: rgba(255, 255, 255, 0.8);
        padding: 2rem;
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }

    .score-display {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .score-item {
        background: rgba(255, 255, 255, 0.9);
        padding: 1.5rem;
        border-radius: 15px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .score-value {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .score-label {
        font-size: 0.9rem;
        color: #6B7280;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .certificate-button {
        background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 15px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0 1rem;
    }

    .certificate-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(139, 92, 246, 0.6);
        color: white;
    }

    .back-button {
        background: rgba(107, 114, 128, 0.8);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 15px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0 1rem;
    }

    .back-button:hover {
        background: rgba(75, 85, 99, 0.9);
        transform: translateY(-2px);
        color: white;
    }

    .buttons-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
    }

    .failed-result {
        background: rgba(239, 68, 68, 0.1);
        border: 2px solid rgba(239, 68, 68, 0.3);
    }

    .failed-icon {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
    }

    .retry-button {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .retry-button:hover {
        box-shadow: 0 15px 35px rgba(59, 130, 246, 0.6);
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .congratulations-title {
            font-size: 2rem;
        }
        
        .result-container {
            margin: 1rem;
            padding: 2rem;
        }
        
        .buttons-container {
            flex-direction: column;
            align-items: center;
        }
        
        .certificate-button, .back-button {
            width: 100%;
            max-width: 300px;
            justify-content: center;
        }
    }
</style>

<div class="container mx-auto px-4">
    <div class="result-container {{ !$attempt->passed ? 'failed-result' : '' }}">
        <!-- Success/Failure Icon -->
        <div class="success-icon {{ !$attempt->passed ? 'failed-icon' : '' }}">
            @if($attempt->passed)
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            @else
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            @endif
        </div>

        <!-- Title -->
        <h1 class="congratulations-title">
            @if($attempt->passed)
                Gratulacje!
            @else
                Niestety...
            @endif
        </h1>

        <!-- Description -->
        <div class="result-description">
            @if($attempt->passed)
                <p>
                    Wspaniale! Pomyślnie ukończyłeś kurs <strong>"{{ $course->title }}"</strong>. 
                    Twoja wiedza i zaangażowanie zostały docenione. Zdobyte punkty zostaną dodane do Twojego konta, 
                    a certyfikat ukończenia kursu jest już dostępny do pobrania.
                </p>
                <p class="mt-4">
                    Dziękujemy za uczestnictwo w szkoleniu. Życzymy dalszych sukcesów w rozwoju zawodowym!
                </p>
            @else
                <p>
                    Niestety, nie udało Ci się uzyskać minimalnej liczby punktów wymaganej do zaliczenia kursu 
                    <strong>"{{ $course->title }}"</strong>. Próg zaliczenia to {{ $attempt->quiz->passing_score }}%, 
                    a Ty uzyskałeś {{ number_format($attempt->percentage, 1) }}%.
                </p>
                <p class="mt-4">
                    Nie martw się! Możesz spróbować ponownie. Zalecamy przejrzenie materiałów kursu 
                    przed kolejną próbą.
                </p>
            @endif
        </div>

        <!-- Score Display -->
        <div class="score-display">
            <div class="score-item">
                <div class="score-value text-blue-600">{{ $attempt->score }}/{{ $attempt->max_score }}</div>
                <div class="score-label">Punkty w teście</div>
            </div>
            <div class="score-item">
                <div class="score-value {{ $attempt->passed ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($attempt->percentage, 1) }}%
                </div>
                <div class="score-label">Wynik procentowy</div>
            </div>
            @if($attempt->passed)
                <div class="score-item">
                    <div class="score-value text-purple-600">{{ $attempt->earned_points }}</div>
                    <div class="score-label">Punkty za kurs</div>
                </div>
            @endif
        </div>

        <!-- Completion Date -->
        <div class="mb-6">
            <div class="text-sm text-gray-600">
                Ukończono: {{ $attempt->completed_at->format('d.m.Y H:i') }}
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="buttons-container">
            <a href="{{ route('courses.show', $course) }}" class="back-button">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Powrót do kursu
            </a>

            @if($attempt->passed)
                <form method="POST" action="{{ route('certificates.generate', $course) }}" class="inline" onsubmit="console.log('Certificate form submitted to:', this.action); return true;">
                    @csrf
                    <button type="submit" class="certificate-button" onclick="console.log('Certificate button clicked. Form action URL:', this.form.action);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Pobierz certyfikat
                    </button>
                </form>
                <!-- Debug info -->
                <div style="font-size: 12px; color: #666; margin-top: 10px;">
                    Debug: Form action URL = {{ route('certificates.generate', $course) }}
                </div>
            @else
                <a href="{{ route('quizzes.show', $course) }}" class="certificate-button retry-button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Spróbuj ponownie
                </a>
            @endif
        </div>

        <!-- Technician Info -->
        @if(auth()->user()->isTechnician())
            <div class="mt-6 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                <div class="flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-orange-800 font-medium">
                        Jako technik farmacji otrzymujesz 80% punktów za poprawne odpowiedzi
                    </span>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection