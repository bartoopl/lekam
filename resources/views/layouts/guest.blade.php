<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts - Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html, body {
                background-image: url('/images/backgrounds/bg.jpg');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                min-height: 100vh;
                font-family: 'Poppins', sans-serif;
            }

            .guest-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                padding: 0;
                padding-top: 100px;
            }

            .content-wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                flex: 1;
                padding: 2rem;
            }

            .logo-container {
                margin-bottom: 2rem;
            }

            .logo-container img {
                width: 150px;
                height: auto;
            }

            .form-wrapper {
                width: 100%;
                max-width: 400px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 2.5rem;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .form-title {
                font-family: 'Poppins', sans-serif;
                font-weight: 700;
                font-size: 1.8rem;
                color: #21235F;
                margin-bottom: 1rem;
                text-align: center;
            }

            .form-description {
                font-family: 'Poppins', sans-serif;
                font-size: 0.9rem;
                color: #6B7280;
                margin-bottom: 2rem;
                text-align: center;
                line-height: 1.5;
            }

            .input-group {
                margin-bottom: 1.5rem;
            }

            .input-label {
                font-family: 'Poppins', sans-serif;
                font-weight: 500;
                font-size: 0.9rem;
                color: #374151;
                margin-bottom: 0.5rem;
                display: block;
            }

            .form-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 2px solid #E5E7EB;
                border-radius: 12px;
                font-family: 'Poppins', sans-serif;
                font-size: 1rem;
                transition: all 0.3s ease;
                background: white;
            }

            .form-input:focus {
                outline: none;
                border-color: #21235F;
                box-shadow: 0 0 0 3px rgba(33, 35, 95, 0.1);
            }

            .btn-primary {
                width: 100%;
                background-color: #21235F;
                color: white;
                border: 2px solid #21235F;
                padding: 0.75rem 1.5rem;
                font-family: 'Poppins', sans-serif;
                font-weight: 600;
                font-size: 1rem;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 1rem;
            }

            .btn-primary:hover {
                background-color: #1a1a4d;
                border-color: #1a1a4d;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(33, 35, 95, 0.3);
            }

            .error-message {
                color: #EF4444;
                font-size: 0.875rem;
                margin-top: 0.5rem;
                font-family: 'Poppins', sans-serif;
            }

            .success-message {
                color: #10B981;
                font-size: 0.875rem;
                margin-bottom: 1rem;
                padding: 0.75rem;
                background: rgba(16, 185, 129, 0.1);
                border-radius: 8px;
                font-family: 'Poppins', sans-serif;
            }

            .back-link {
                text-align: center;
                margin-top: 1.5rem;
            }

            .back-link a {
                color: #21235F;
                text-decoration: none;
                font-family: 'Poppins', sans-serif;
                font-weight: 500;
                font-size: 0.9rem;
                transition: color 0.3s ease;
            }

            .back-link a:hover {
                color: #1a1a4d;
                text-decoration: underline;
            }

            /* Footer */
            .footer {
                background-image: url('/images/backgrounds/wave.png');
                background-size: cover;
                background-position: center;
                background-color: #10113d;
                background-blend-mode: overlay;
                position: relative;
                color: white;
                padding: 4rem 0 2rem 0;
                width: 100%;
            }

            .footer::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, #10113d 0%, #1a1e5a 100%);
                opacity: 0.2;
                z-index: 1;
            }

            .footer-content {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 2rem;
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr;
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
                filter: brightness(0) invert(1);
                margin-bottom: 20px;
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
            .footer-right,
            .footer-patronage {
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

            @media (max-width: 768px) {
                .guest-container {
                    padding: 1rem;
                }

                .form-wrapper {
                    padding: 2rem;
                }

                .logo-container img {
                    width: 120px;
                }

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
        @include('layouts.navigation')

        <style>
            /* Ensure navbar styles are applied on guest pages */
            .navbar-container .logo-icon {
                width: 100px !important;
                height: auto !important;
            }

            .navbar-container .navbar-content {
                padding: 1rem 2rem !important;
            }
        </style>

        <div class="guest-container">
            <div class="content-wrapper">
                <div class="logo-container">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logos/logo.svg') }}" alt="LEK-AM Akademia">
                    </a>
                </div>

                <div class="form-wrapper">
                    {{ $slot }}
                </div>

                <div class="back-link">
                    <a href="{{ route('home') }}">← Powrót do strony głównej</a>
                </div>
            </div>

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
                        </ul>
                    </div>

                    <div class="footer-right">
                        <h3 class="footer-section-title">Linki</h3>
                        <ul class="footer-links">
                            <li><a href="{{ route('courses') }}" class="footer-link">Szkolenia</a></li>
                            <li><a href="{{ route('contact') }}" class="footer-link">Kontakt</a></li>
                        </ul>
                    </div>

                    <div class="footer-patronage">
                        <h3 class="footer-section-title" style="text-align: center;">Patronat Merytoryczny</h3>
                        <div style="display: flex; align-items: center; justify-content: center; margin-top: 1rem;">
                            <img src="/images/icons/gumed.png?v=2" alt="GUMed" style="height: 120px; width: auto;">
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="footer-bottom-left">
                        <div style="display: flex; align-items: flex-end;">
                            <span>&copy; 2025 Wszelkie Prawa zastrzeżone</span>
                            <img src="/images/icons/lekam.png" alt="Lekam" style="height: 24px; margin-left: 8px; margin-bottom: 6px;">
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
        </div>
    </body>
</html>
