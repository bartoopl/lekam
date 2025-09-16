<?php 
error_reporting(0); 
ini_set('display_errors', 0);
ob_start();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Szkolenia - LEK-AM Akademia</title>

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.navigation')

    <style>
        /* Hide PHP errors completely */
        br:first-of-type,
        br:first-of-type + b,
        b:contains("Notice"),
        b:contains("file_put_contents"),
        b:contains("Broken pipe") {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            position: absolute !important;
            left: -9999px !important;
        }
        
        /* Hide any PHP error messages */
        br + b {
            display: none !important;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            background-image: url('/images/backgrounds/bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        
        /* Hero Section */
        .hero-section {
            background-image: url('/images/backgrounds/wave.png');
            background-size: cover;
            background-position: center;
            background-color: #21235F;
            background-blend-mode: overlay;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            top: 0;
            z-index: 1;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #21235F 0%, #2D3A8C 40%);
            opacity: 0.2;
            z-index: 1;
        }
        
        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 120px 2rem 4rem 2rem;
            display: flex;
            align-items: center;
            gap: 4rem;
            position: relative;
            z-index: 2;
        }
        
        .hero-left {
            flex: 1;
        }
        
        .hero-image {
            max-width: 100%;
            height: auto;
            animation: float 6s ease-in-out infinite;
        }
        
        .hero-right {
            flex: 1;
            padding-left: 2rem;
        }
        
        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 3.5rem;
            line-height: 1.1;
            color: white;
            margin-bottom: 1.5rem;
            animation: slideInRight 1s ease-out;
        }
        
        .hero-description {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 1.1rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            animation: slideInRight 1s ease-out 0.2s both;
        }
        
        /* Courses Grid Section */
        .courses-section {
            padding: 4rem 0;
            position: relative;
        }
        
        .courses-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
            justify-items: start;
        }
        
        .course-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        .course-image-container {
            position: relative;
            width: 100%;
            height: 250px;
            overflow: hidden;
        }
        
        .course-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .course-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            z-index: 2;
        }
        
        .course-content {
            padding: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .course-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.4rem;
            color: #21235F;
            margin-bottom: 1rem;
            line-height: 1.3;
        }
        
        .course-description {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            color: #6B7280;
            line-height: 1.6;
            margin-bottom: 2rem;
            flex: 1;
        }
        

        
        /* Animations */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
                padding: 2rem 1rem;
            }
            
            .hero-right {
                padding-left: 0;
                margin-top: 2rem;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .courses-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }
        
        /* Footer */
        .footer {
            background-image: url('/images/backgrounds/wave.png');
            background-size: cover;
            background-position: center;
            background-color: #21235F;
            background-blend-mode: overlay;
            position: relative;
            color: white;
            padding: 4rem 0 2rem 0;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #21235F 0%, #2D3A8C 100%);
            opacity: 0.2;
            z-index: 1;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 3rem;
            position: relative;
            z-index: 2;
        }
        
        .footer-left {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .footer-logo-icon {
            width: 120px;
            height: 120px;
            filter: brightness(0) invert(1); /* Makes logo white */
        }
        
        .footer-description {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }
        
        .footer-center,
        .footer-right {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .footer-section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            margin: 0;
        }
        
        .footer-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .footer-link {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 2rem 0 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .footer-bottom-left,
        .footer-bottom-right {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .footer-admin-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-admin-link:hover {
            color: white;
        }
        
        /* Footer Responsive */
        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
            }
            
            .footer-bottom {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    @guest
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-left">
                <img src="/images/backgrounds/rectangle.png" alt="Hero" class="hero-image">
            </div>
            <div class="hero-right">
                <h1 class="hero-title">Szkolenia</h1>
                <p class="hero-description">Szkolenia Akademii Lek‑am zostały przygotowane z najwyższą dbałością jeśli chodzi o wartość merytoryczną, są zawsze zgodne z aktualnymi standardami i wymaganiami współczesnej farmacji. Prowadzą je renomowani wykładowcy i eksperci z wieloletnim doświadczeniem. Nasza oferta obejmuje starannie opracowane kursy, które wspierają rozwój zawodowy farmaceutów i techników farmacji, łącząc rzetelną wiedzę z praktycznym podejściem do codziennej pracy.</p>
            </div>
        </div>
    </section>
    @endguest
    
    <!-- Courses Grid Section -->
    <section class="courses-section" @auth style="padding-top: 120px;" @endauth>
        <div class="courses-content">
            <div class="courses-grid">
                @foreach($courses as $course)
                    <div class="course-card">
                        <div class="course-image-container">
                            @if($course->image)
                                <img src="{{ str_starts_with($course->image, 'http') ? $course->image : Storage::url($course->image) }}" alt="{{ $course->title }}" class="course-image">
                            @else
                                <div class="course-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                            @if(auth()->check() && auth()->user()->hasStartedCourse($course))
                                <div class="course-status">W trakcie</div>
                            @elseif(auth()->check() && auth()->user()->hasCompletedCourse($course))
                                <div class="course-status">Ukończony</div>
                            @endif
                        </div>
                        <div class="course-content">
                            <h3 class="course-title">{{ $course->title }}</h3>
                            <p class="course-description">{{ Str::limit($course->description, 120) }}</p>
                                                            @auth
                                    <a href="{{ route('courses.show', $course->id) }}" class="course-button {{ auth()->user()->hasStartedCourse($course) ? 'continue' : '' }}">
                                        @if(auth()->user()->hasStartedCourse($course))
                                            Kontynuuj
                                        @else
                                            Dołącz do szkolenia
                                        @endif
                                    </a>
                                @else
                                    <div class="course-auth-buttons">
                                        <a href="{{ route('login') }}" class="course-button login">Zaloguj się</a>
                                        <a href="{{ route('register') }}" class="course-button register">Zarejestruj się</a>
                                    </div>
                                @endauth
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($courses->hasPages())
                <div class="pagination-container" style="margin-top: 3rem; text-align: center;">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <div class="footer-logo">
                    <img src="/images/logos/logo.svg" alt="Lekam Akademia" class="footer-logo-icon">
                </div>
                <p class="footer-description">Zdobywaj wiedzę i punkty edukacyjne w Akademii Lekam</p>
            </div>
            
            <div class="footer-center">
                <h3 class="footer-section-title">Ważne odnośniki</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('terms') }}" class="footer-link">Regulamin Serwisu</a></li>
                    <li><a href="{{ route('privacy') }}" class="footer-link">Polityka Prywatności</a></li>
                    <li><a href="{{ route('cookies') }}" class="footer-link">Polityka Plików Cookies</a></li>
                </ul>
            </div>
            
            <div class="footer-right">
                <h3 class="footer-section-title">Linki</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('courses') }}" class="footer-link">Szkolenia</a></li>
                    <li><a href="{{ route('contact') }}" class="footer-link">Kontakt</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-bottom-left">
                <div style="display: flex; align-items: center;">
                    <span>&copy; 2025 Wszelkie Prawa zastrzeżone</span>
                    <img src="/images/icons/lekam.png" alt="Lekam" style="height: 24px; margin-left: 8px;">
                </div>
            </div>
            <div class="footer-bottom-right">
                <div style="display: flex; align-items: center; justify-content: flex-end;">
                    <span>Administrator serwisu:</span>
                    <a href="https://neoart.pl" target="_blank" class="footer-admin-link" style="margin-left: 8px;">
                        <img src="/images/icons/neoart.png" alt="Neoart" style="height: 24px;">
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        // Hide PHP errors immediately when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Hide any PHP error messages
            const elements = document.querySelectorAll('br, b');
            elements.forEach(function(element) {
                if (element.textContent && element.textContent.includes('Notice')) {
                    element.style.display = 'none';
                }
                if (element.textContent && element.textContent.includes('file_put_contents')) {
                    element.style.display = 'none';
                }
                if (element.textContent && element.textContent.includes('Broken pipe')) {
                    element.style.display = 'none';
                }
            });
        });
        
        // Also hide immediately for faster hiding
        window.addEventListener('load', function() {
            const elements = document.querySelectorAll('br, b');
            elements.forEach(function(element) {
                if (element.textContent && (element.textContent.includes('Notice') || element.textContent.includes('file_put_contents') || element.textContent.includes('Broken pipe'))) {
                    element.style.display = 'none';
                }
            });
        });
    </script>
    <?php
    $output = ob_get_clean();
    // Remove PHP error messages from output
    $output = preg_replace('/<br \/>\s*<b>Notice<\/b>.*?<\/b><br \/>/s', '', $output);
    echo $output;
    ?>
</body>
</html>
