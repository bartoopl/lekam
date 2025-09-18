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

    <title>{{ config('app.name', 'Platforma Farmaceutyczna') }} - {{ time() }}</title>

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS is included via Vite build process -->

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            background: linear-gradient(135deg, #21235F 0%, #2a2d7a 100%);
            opacity: 0.2;
            z-index: 1;
        }
        
        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 120px 2rem 0 2rem;
            min-height: 100vh;
            width: 100%;
            position: relative;
            z-index: 2;
        }
        
        .hero-left {
            flex: 1;
            animation: slideInLeft 1s ease-out;
        }
        
        .hero-right {
            flex: 1;
            color: white;
            padding-left: 4rem;
            animation: slideInRight 1s ease-out 0.3s both;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            animation: fadeInUp 1s ease-out 0.6s both;
        }
        
        .hero-description {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out 0.9s both;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            animation: fadeInUp 1s ease-out 1.2s both;
        }
        
        .hero-btn-primary {
            background: #E0E7FA;
            color: black;
            border: none;
            border-radius: 16px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .hero-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(224, 231, 250, 0.3);
        }
        
        .hero-btn-secondary {
            background: transparent;
            color: #E0E7FA;
            border: 2px solid #E0E7FA;
            border-radius: 16px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .hero-btn-secondary:hover {
            background: #E0E7FA;
            color: black;
            transform: translateY(-2px);
        }
        
        .hero-image {
            max-width: 100%;
            height: auto;
            animation: float 6s ease-in-out infinite;
        }
        
        /* Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
        
        /* About Academy Section */
        .about-section {
            padding: 4rem 0;
            position: relative;
        }
        
        .about-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: flex-start;
            gap: 2rem;
            position: relative;
            z-index: 2;
        }
        
        .about-left {
            flex: 0 0 auto;
            padding-top: 0;
        }
        
        .badge {
            display: inline-block;
            border: 1px solid #21235F;
            border-radius: 20px;
            padding: 0.75rem 1.5rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            color: #21235F;
            background: transparent;
        }
        
        .about-right {
            flex: 2;
        }
        
        .about-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            line-height: 1.2;
            color: #21235F;
            margin: 0;
        }
        
        /* Features Section */
        .features-section {
            padding: 2rem 0;
        }
        
        .features-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: stretch;
            gap: 4rem;
        }
        
        .features-left {
            flex: 1;
            display: flex;
            align-items: stretch;
        }
        
        .features-image {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 20px;
            flex: 1;
        }
        
        .features-right {
            flex: 1;
            background: #E0E7FA;
            border-radius: 20px;
            padding: 2rem;
            height: auto;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        
        .feature-block {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(33, 35, 95, 0.1);
        }
        
        .feature-block:last-child {
            border-bottom: none;
        }
        
        .feature-icon {
            color: #21235F;
            flex-shrink: 0;
            font-size: 1.5rem;
            margin-top: 0.25rem;
        }
        
        .feature-content {
            flex: 1;
        }
        
        .feature-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            color: #21235F;
            margin-bottom: 0.5rem;
        }
        
        .feature-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 0.9rem;
            color: #374151;
            line-height: 1.6;
            margin-bottom: 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .about-content {
                flex-direction: column;
                text-align: center;
                gap: 2rem;
            }
            
            .about-title {
                font-size: 2rem;
            }
            
            .features-content {
                flex-direction: column;
                gap: 2rem;
            }
            
            .features-left {
                order: 2;
            }
            
            .features-right {
                order: 1;
            }
            
            .features-image {
                height: 250px;
                width: 100%;
            }
            
            .features-right {
                min-height: auto;
            }
        }

        /* Trainings Section */
        .trainings-section {
            padding: 4rem 0;
            position: relative;
        }
        
        .trainings-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 4rem;
        }
        
        .trainings-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .trainings-header {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .trainings-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            line-height: 1.2;
            color: #21235F;
            margin: 0;
        }
        
        .trainings-description {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.6;
            color: #374151;
            margin: 0;
        }
        
        .trainings-right {
            flex: 1;
        }
        
        .trainings-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 20px;
        }
        
        .trainings-badge {
            display: inline-block;
            border: 1px solid #21235F;
            border-radius: 20px;
            padding: 0.75rem 1.5rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            color: #21235F;
            background: transparent;
            width: fit-content;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .trainings-content {
                flex-direction: column;
                text-align: center;
                gap: 2rem;
            }
            
            .trainings-title {
                font-size: 2rem;
            }
            
            .trainings-image {
                height: 300px;
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
            background: linear-gradient(135deg, #21235F 0%, #2a2d7a 100%);
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
    <!-- Include Navigation -->
    @include('layouts.navigation')
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-left">
                <img src="/images/hero-left.png" alt="Hero Image" class="hero-image">
            </div>
            <div class="hero-right">
                <h1 class="hero-title">Akademia LEK-AM<br>Lepsza strona farmacji.</h1>
                <p class="hero-description">
                <b>Witaj w serwisie stworzonym z myślą o farmaceutach i technikach farmacji.</b> To wymagające zawody – nie tylko ze względu na codzienną pracę w aptece, ale także przez wpisaną w nie potrzebę stałego rozwoju. Akademia LEK-AM wspiera Cię w tym procesie. Zarejestruj konto, aby zyskać dostęp do bezpłatnych szkoleń, zdobywać punkty edukacyjne i poszerzać wiedzę – bez wychodzenia z domu.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="hero-btn-primary">Zarejestruj się →</a>
                    <a href="{{ route('login') }}" class="hero-btn-secondary">Zaloguj się →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Academy Section -->
    <section class="about-section" id="about">
        <div class="about-content">
            <div class="about-left">
                <div class="badge">
                    O akademii LEK-AM
                </div>
            </div>
            <div class="about-right">
                <h2 class="about-title">
                Farmacja. Wiedza. Rozwój. Zdalnie. Prosto. Efektywnie. Akademia. Zapisz się na przyszłość.
                </h2>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-content">
            <div class="features-left">
                <img src="/images/backgrounds/pharmacy.jpeg" alt="Pharmacy" class="features-image">
            </div>
            <div class="features-right">
                <div class="feature-block">
                    <div class="feature-icon">
                        <img src="/images/icons/ikona1.svg" alt="Icon 1" class="w-8 h-8">
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">Z potrzeby - dla praktyki</h3>
                        <p class="feature-text">Akademia Lek-am powstała z potrzeby – realnej, zauważonej w codziennym kontakcie z farmaceutami i technikami farmacji. To odpowiedź na wyzwania zawodów, wymagających ciągłego rozwoju i dostępu do aktualnej wiedzy.
                    </div>
                </div>
                
                <div class="feature-block">
                    <div class="feature-icon">
                        <img src="/images/icons/ikona2.svg" alt="Icon 2" class="w-8 h-8">
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">Wiedza - wsparcie - rozwój</h3>
                        <p class="feature-text">Od lat wspieramy środowisko medyczne, dostarczając rzetelną wiedzę i praktyczne narzędzia rozwoju Akademia to miejsce stworzone przez ekspertów z myślą o kształceniu zawodowym na najwyższym poziomie. Dołącz do nas i przekonaj się, że warto być tam, gdzie wiedza ma wartość, a edukacja – konkretny kierunek.
                    </div>
                </div>
                
                <div class="feature-block">
                    <div class="feature-icon">
                        <img src="/images/icons/ikona3.svg" alt="Icon 3" class="w-8 h-8">
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">Nasza idea - wiedzieć więcej</h3>
                        <p class="feature-text">Sama idea akademii sięga starożytności – to tam, w gaju Akademosa, narodziła się wspólnota nauki i myśli. Dziś, w nowoczesnej formule, Akademia LEK-AM kontynuuje tego ducha: jako przestrzeń dla tych, którzy chcą rozwijać się świadomie, odpowiedzialnie i w zgodzie z wymaganiami współczesnej farmacji.
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Trainings Section -->
    <section class="trainings-section">
        <div class="trainings-content">
            <div class="trainings-left">
                <div class="badge trainings-badge">Szkolenia</div>
                <h2 class="trainings-title">Nowoczesna edukacja online. Profesjonalnie, wygodnie, skutecznie.</h2>
                <p class="trainings-description">W Akademii LEK-AM szkolisz się wtedy, gdy Ci wygodnie – bez grafiku, dojazdów i formalności. Wybierasz interesujący Cię temat, oglądasz wykład prowadzony przez eksperta, rozwiązujesz test i pobierasz certyfikat – wszystko w intuicyjnym systemie online.
Treści są merytoryczne, zawsze zgodne z aktualną wiedzą, a zajęcia prowadzone przez renomowanych wykładowcó, specjalistów w danej dziedzinie.  To rozwiązanie stworzone z myślą o farmaceutach i technikach farmacji, którzy cenią jakość, prostotę i efektywność.


            </div>
            <div class="trainings-right">
                <img src="/images/backgrounds/rectangle.png" alt="Trainings" class="trainings-image">
            </div>
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
                    <li><a href="{{ route('privacy') }}" class="footer-link">Polityka Prywatności</a></li>
                    <li><a href="{{ route('cookies') }}" class="footer-link">Polityka Plików Cookies</a></li>
                    <li><a href="#" onclick="openCookieModal(); return false;" class="footer-link">Zarządzanie cookies</a></li>
                </ul>
            </div>
            
            <div class="footer-right">
                <h3 class="footer-section-title">Linki</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('courses') }}" class="footer-link">Szkolenia</a></li>
                    <li><a href="#" class="footer-link">Kontakt</a></li>
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

    <!-- Cookie Consent Banner -->
    @include('components.cookie-banner')

    <script src="{{ asset('js/cookie-consent.js') }}"></script>

    <!-- Ensure openCookieModal is available globally -->
    <script>
        // Define openCookieModal immediately to avoid ReferenceError
        window.openCookieModal = function() {
            if (window.CookieConsent && window.CookieConsent.showModal) {
                window.CookieConsent.showModal();
            } else {
                console.log('Waiting for CookieConsent to initialize...');
                // Try multiple times with increasing delays
                let attempts = 0;
                const tryAgain = function() {
                    attempts++;
                    if (window.CookieConsent && window.CookieConsent.showModal) {
                        window.CookieConsent.showModal();
                    } else if (attempts < 10) {
                        setTimeout(tryAgain, attempts * 100);
                    } else {
                        console.error('CookieConsent failed to initialize after 10 attempts');
                    }
                };
                setTimeout(tryAgain, 100);
            }
        };
    </script>

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
