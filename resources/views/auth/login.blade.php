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

        /* Login Footer */
        .login-footer {
            margin-top: 3rem;
            padding: 2rem 0;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .login-footer-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        .login-footer-link:hover {
            color: white;
            text-decoration: underline;
        }

        .login-footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: rgba(255, 255, 255, 0.6);
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .login-footer-admin {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .login-footer-admin img {
            height: 20px;
            opacity: 0.8;
        }

        .login-footer-admin a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-footer-admin a:hover {
            color: rgba(255, 255, 255, 0.9);
        }

        @media (max-width: 768px) {
            .login-footer-content {
                flex-direction: column;
                gap: 1rem;
            }

            .login-footer-bottom {
                flex-direction: column;
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

            <!-- Login Footer -->
            <footer class="login-footer">
                <div class="login-footer-content">
                    <a href="{{ route('privacy') }}" class="login-footer-link">Polityka Prywatności</a>
                    <a href="{{ route('cookies') }}" class="login-footer-link">Polityka Cookies</a>
                    <a href="{{ route('contact') }}" class="login-footer-link">Kontakt</a>
                </div>
                <div class="login-footer-bottom">
                    <div>
                        <span>&copy; 2025 Wszelkie Prawa zastrzeżone</span>
                    </div>
                    <div class="login-footer-admin">
                        <span>Administrator serwisu:</span>
                        <a href="https://neoart.pl" target="_blank">
                            <img src="/images/icons/neoart.png" alt="Neoart">
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
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
