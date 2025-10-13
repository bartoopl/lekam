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

    <title>Zaloguj się - LEK-AM Akademia</title>

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            font-family: 'Poppins', sans-serif;
        }
        
        /* Login Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            padding-top: 150px; /* Increased spacing from navbar */
        }
        
        .login-content {
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        
        .login-header {
            margin-bottom: 2rem;
        }
        
        .login-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: #21235F;
            margin-bottom: 1rem;
        }
        
        .login-description {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 1.1rem;
            color: #6B7280;
            line-height: 1.6;
        }
        
        /* Form Styling */
        .login-form {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        
        .form-label {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            color: #374151;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #21235F;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(33, 35, 95, 0.1);
        }
        
        .form-input::placeholder {
            color: #9CA3AF;
        }
        
        .login-button {
            width: 100%;
            background: linear-gradient(135deg, #21235F 0%, #3B82F6 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        /* Button styles for login page */
        .btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0.75rem 1.5rem !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            line-height: 1.25rem !important;
            border-radius: 12px !important;
            border: 2px solid transparent !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            white-space: nowrap !important;
            user-select: none !important;
            opacity: 1 !important;
            visibility: visible !important;
            margin: 0 !important;
        }
        
        .btn-primary {
            background-color: #21235F !important;
            color: white !important;
            border: 2px solid #21235F !important;
            width: 100% !important;
        }
        
        .btn-primary:hover {
            background-color: #1a1a4d !important;
            border-color: #1a1a4d !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(33, 35, 95, 0.3) !important;
        }
        
        .forgot-password {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 0.9rem;
            color: #6B7280;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .forgot-password:hover {
            color: #21235F;
        }
        
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #DC2626;
            padding: 0.75rem;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-title {
                font-size: 2rem;
            }
            
            .login-form {
                padding: 2rem;
            }
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
            margin-top: 4rem;
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
            filter: brightness(0) invert(1); /* Makes logo white */
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
    <div class="login-container">
        <div class="login-content">
            <div class="login-header">
                <h1 class="login-title">Zaloguj się</h1>
                <p class="login-description">Witaj ponownie! Zaloguj się do swojego konta, aby kontynuować naukę.</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                
                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif
                
                <div class="form-group">
                    <label for="email" class="form-label">E-mail</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="form-input"
                        placeholder="Wprowadź swój e-mail"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Hasło</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="form-input"
                        placeholder="Wprowadź swoje hasło"
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Zaloguj się
                </button>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        Zapomniałeś hasła?
                    </a>
                @endif
            </form>

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

            <div class="footer-patronage">
                <h3 class="footer-section-title" style="text-align: center;">Patronat Merytoryczny</h3>
                <div style="display: flex; align-items: center; justify-content: center; margin-top: 1rem;">
                    <img src="/images/icons/gumed.png?v=3" alt="GUMed" style="height: 120px; width: auto;">
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-left">
                <div style="display: flex; align-items: flex-end;">
                    <span>&copy; 2025 Wszelkie Prawa zastrzeżone</span>
                    <img src="/images/icons/lekam.png" alt="Lekam" style="height: 24px; margin-left: 8px; margin-bottom: 6px; vertical-align: bottom;">
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
