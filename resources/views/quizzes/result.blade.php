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
        width: 120px !important;
        height: 120px !important;
        margin: 0 auto 2rem !important;
        background: linear-gradient(135deg, #10B981 0%, #059669 100%) !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4) !important;
        animation: pulse 2s infinite !important;
    }
    
    .success-icon svg {
        width: 4rem !important;
        height: 4rem !important;
        color: white !important;
        stroke: white !important;
        fill: none !important;
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
        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%) !important;
        color: white !important;
        padding: 1rem 2.5rem !important;
        border-radius: 50px !important;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 700 !important;
        font-size: 1.1rem !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4) !important;
        border: none !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.75rem !important;
        margin: 0 1rem !important;
    }

    .certificate-button:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 15px 35px rgba(59, 130, 246, 0.6) !important;
        color: white !important;
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%) !important;
    }

    .back-button {
        background: rgba(107, 114, 128, 0.9) !important;
        color: white !important;
        padding: 1rem 2.5rem !important;
        border-radius: 50px !important;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
        backdrop-filter: blur(10px) !important;
        border: 2px solid rgba(107, 114, 128, 0.8) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.75rem !important;
        margin: 0 1rem !important;
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3) !important;
    }

    .back-button:hover {
        background: rgba(75, 85, 99, 1.0) !important;
        transform: translateY(-2px) !important;
        color: white !important;
        box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4) !important;
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
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%) !important;
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4) !important;
    }
    
    .failed-icon svg {
        width: 4rem !important;
        height: 4rem !important;
        color: white !important;
        stroke: white !important;
        fill: none !important;
    }

    .retry-button {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%) !important;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4) !important;
        border-radius: 50px !important;
    }

    .retry-button:hover {
        box-shadow: 0 15px 35px rgba(59, 130, 246, 0.6) !important;
        color: white !important;
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
                    <div class="score-value text-purple-600">{{ $course->getPointsForUser(auth()->user()) }}</div>
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
                ← Powrót do kursu
            </a>

            @if($attempt->passed)
                <form method="POST" action="/courses/{{ $course->id }}/certificate/generate" class="inline">
                    @csrf
                    <button type="submit" class="certificate-button">
                        📜 Pobierz certyfikat
                    </button>
                </form>
            @else
                <a href="{{ route('quizzes.show', $course) }}" class="certificate-button retry-button">
                    🔄 Spróbuj ponownie
                </a>
            @endif
        </div>

    </div>
</div>

@if($attempt->passed)
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confetti burst when page loads (course completion celebration)
        
        // First burst - from center
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });
        
        // Second burst after 200ms - from left
        setTimeout(() => {
            confetti({
                particleCount: 50,
                angle: 60,
                spread: 55,
                origin: { x: 0 }
            });
        }, 200);
        
        // Third burst after 400ms - from right
        setTimeout(() => {
            confetti({
                particleCount: 50,
                angle: 120,
                spread: 55,
                origin: { x: 1 }
            });
        }, 400);
        
        // Continuous golden confetti for 3 seconds
        const duration = 3 * 1000;
        const animationEnd = Date.now() + duration;
        const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        const interval = setInterval(function() {
            const timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            const particleCount = 50 * (timeLeft / duration);
            
            // Golden confetti from random positions
            confetti(Object.assign({}, defaults, { 
                particleCount,
                origin: { x: randomInRange(0.1, 0.9), y: Math.random() - 0.2 },
                colors: ['#FFD700', '#FFA500', '#FF8C00', '#DAA520', '#B8860B']
            }));
        }, 250);
    });
</script>
@endif
@endsection