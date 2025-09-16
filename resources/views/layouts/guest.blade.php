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
                justify-content: center;
                align-items: center;
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
            }
        </style>
    </head>
    <body>
        <div class="guest-container">
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
    </body>
</html>
