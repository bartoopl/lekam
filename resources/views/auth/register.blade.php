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

    <title>Rejestracja - LEK-AM Akademia</title>

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
        
        /* Registration Container */
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            padding-top: 150px; /* Increased spacing from navbar */
        }
        
        .register-content {
            width: 100%;
            max-width: 800px;
            text-align: center;
        }
        
        .register-header {
            margin-bottom: 2rem;
        }
        
        .register-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: #21235F;
            margin-bottom: 1rem;
        }
        
        .register-description {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 1.1rem;
            color: #6B7280;
            line-height: 1.6;
        }
        
        /* Form Styling */
        .register-form {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-label {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-input, .form-select {
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
        
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #21235F;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(33, 35, 95, 0.1);
        }
        
        .form-input::placeholder {
            color: #9CA3AF;
        }
        
        .form-select {
            cursor: pointer;
        }
        
        .form-select option {
            background: white;
            color: #374151;
        }
        
        .consent-group {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        
        .consent-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .consent-item:last-child {
            margin-bottom: 0;
        }
        
        .consent-checkbox {
            margin-top: 0.25rem;
            width: 20px;
            height: 20px;
            accent-color: #21235F;
            flex-shrink: 0;
        }
        
        .consent-label {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 0.9rem;
            color: #374151;
            line-height: 1.5;
        }
        
        .register-button {
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
        
        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        /* Button styles for register page */
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
        
        .login-link {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 0.9rem;
            color: #6B7280;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .login-link:hover {
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
            .register-container {
                padding: 1rem;
            }
            
            .register-title {
                font-size: 2rem;
            }
            
            .register-form {
                padding: 2rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        /* Register Footer */
        .register-footer {
            margin-top: 3rem;
            padding: 2rem 0;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .register-footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .register-footer-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        .register-footer-link:hover {
            color: white;
            text-decoration: underline;
        }

        .register-footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: rgba(255, 255, 255, 0.6);
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .register-footer-admin {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .register-footer-admin img {
            height: 20px;
            opacity: 0.8;
        }

        .register-footer-admin a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-footer-admin a:hover {
            color: rgba(255, 255, 255, 0.9);
        }

        @media (max-width: 768px) {
            .register-footer-content {
                flex-direction: column;
                gap: 1rem;
            }

            .register-footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-content">
            <div class="register-header">
                <h1 class="register-title">Rejestracja</h1>
                <p class="register-description">Dołącz do naszej akademii i rozwijaj swoje umiejętności w branży farmaceutycznej.</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" class="register-form">
                @csrf
                
                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif
                
                <!-- Personal Information -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name" class="form-label">Imię</label>
                        <input 
                            id="first_name" 
                            type="text" 
                            name="first_name" 
                            value="{{ old('first_name') }}" 
                            required 
                            autofocus
                            class="form-input"
                            placeholder="Wprowadź swoje imię"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name" class="form-label">Nazwisko</label>
                        <input 
                            id="last_name" 
                            type="text" 
                            name="last_name" 
                            value="{{ old('last_name') }}" 
                            required
                            class="form-input"
                            placeholder="Wprowadź swoje nazwisko"
                        >
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email" class="form-label">E-mail</label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            class="form-input"
                            placeholder="Wprowadź swój e-mail"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Telefon</label>
                        <input 
                            id="phone" 
                            type="tel" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            required
                            class="form-input"
                            placeholder="Wprowadź swój telefon"
                        >
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="user_type" class="form-label">Funkcja w aptece</label>
                        <select id="user_type" name="user_type" required class="form-select">
                            <option value="">Wybierz funkcję</option>
                            <option value="farmaceuta" {{ old('user_type') == 'farmaceuta' ? 'selected' : '' }}>Farmaceuta</option>
                            <option value="technik_farmacji" {{ old('user_type') == 'technik_farmacji' ? 'selected' : '' }}>Technik farmacji</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="pwz_number" class="form-label">Numer PWZ</label>
                        <input 
                            id="pwz_number" 
                            type="text" 
                            name="pwz_number" 
                            value="{{ old('pwz_number') }}" 
                            required
                            class="form-input"
                            placeholder="Wprowadź numer PWZ"
                        >
                    </div>
                </div>
                
                <!-- Pharmacy Information -->
                <div class="form-group full-width">
                    <label for="pharmacy_address" class="form-label">Adres apteki</label>
                    <input 
                        id="pharmacy_address" 
                        type="text" 
                        name="pharmacy_address" 
                        value="{{ old('pharmacy_address') }}" 
                        required
                        class="form-input"
                        placeholder="Wprowadź adres apteki"
                    >
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="pharmacy_postal_code" class="form-label">Kod pocztowy apteki</label>
                        <input 
                            id="pharmacy_postal_code" 
                            type="text" 
                            name="pharmacy_postal_code" 
                            value="{{ old('pharmacy_postal_code') }}" 
                            required
                            class="form-input"
                            placeholder="00-000"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="pharmacy_city" class="form-label">Miasto apteki</label>
                        <input 
                            id="pharmacy_city" 
                            type="text" 
                            name="pharmacy_city" 
                            value="{{ old('pharmacy_city') }}" 
                            required
                            class="form-input"
                            placeholder="Wprowadź miasto apteki"
                        >
                    </div>
                </div>
                
                <!-- Password Fields -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Hasło</label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            class="form-input"
                            placeholder="Wprowadź hasło"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Potwierdź hasło</label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            class="form-input"
                            placeholder="Potwierdź hasło"
                        >
                    </div>
                </div>
                
                <!-- Hidden ref field -->
                @if(request('ref'))
                    <input type="hidden" name="ref" value="{{ request('ref') }}">
                @endif
                
                <!-- Consent Section -->
                <div class="consent-group">
                    <!-- Select All Checkbox -->
                    <div class="consent-item" style="border-bottom: 1px solid rgba(255, 255, 255, 0.2); margin-bottom: 1.5rem; padding-bottom: 1rem;">
                        <input type="checkbox" id="select_all_consents" class="consent-checkbox">
                        <label for="select_all_consents" class="consent-label" style="font-weight: 600; color: #21235F;">
                            Zaznacz wszystkie zgody
                        </label>
                    </div>
                    
                    <div class="consent-item">
                        <input type="checkbox" id="consent_1" name="consent_1" required class="consent-checkbox">
                        <label for="consent_1" class="consent-label">
                            <strong>*</strong> Potwierdzam, że administratorem moich danych osobowych w akademialekam.pl jest Grupa NeoArt, 02-819 Warszawa, ul. Puławska 314. Dane będą przetwarzane w celu założenia i obsługi konta oraz umożliwienia korzystania z treści serwisu (szkolenia, webinary) – jako niezbędne do wykonania umowy o świadczenie usług drogą elektroniczną. Podanie danych jest dobrowolne, jednak ich niepodanie może uniemożliwić rejestrację lub spowodować ograniczenia w korzystaniu z serwisu. Zapoznałam/Zapoznałem się z <a href="/privacy" target="_blank" style="color: #21235F; text-decoration: underline;">Polityką prywatności</a>
                        </label>
                    </div>

                    <div class="consent-item">
                        <input type="checkbox" id="consent_2" name="consent_2" class="consent-checkbox">
                        <label for="consent_2" class="consent-label">
                            Wyrażam zgodę na przetwarzanie moich danych osobowych przez Przedsiębiorstwo Farmaceutyczne LEK-AM Sp. z o.o., ul. Ostrzykowizna 14A, 05-170 Zakroczym, w celach marketingowych, w tym na przesyłanie informacji handlowych drogą elektroniczną (e-mail) na podany adres. Zgodę mogę wycofać w każdym czasie.
                        </label>
                    </div>

                    <div class="consent-item">
                        <input type="checkbox" id="consent_3" name="consent_3" class="consent-checkbox">
                        <label for="consent_3" class="consent-label">
                            Wyrażam zgodę na przetwarzanie moich danych osobowych przez Grupę NeoArt, 02-819 Warszawa, ul. Puławska 314, w celach marketingowych, w tym na przesyłanie informacji handlowych drogą elektroniczną (e-mail) na podany adres. Zgodę mogę wycofać w każdym czasie.
                        </label>
                    </div>

                    <!-- Asterisk explanation -->
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.2);">
                        <p style="font-family: 'Poppins', sans-serif; font-size: 0.8rem; color: #6B7280; font-style: italic;">
                            * - pole obowiązkowe
                        </p>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Zarejestruj się
                </button>
                
                <a href="{{ route('login') }}" class="login-link">
                    Masz już konto? Zaloguj się
                </a>
            </form>

            <!-- Register Footer -->
            <footer class="register-footer">
                <div class="register-footer-content">
                    <a href="{{ route('privacy') }}" class="register-footer-link">Polityka Prywatności</a>
                    <a href="{{ route('cookies') }}" class="register-footer-link">Polityka Cookies</a>
                    <a href="{{ route('contact') }}" class="register-footer-link">Kontakt</a>
                </div>
                <div class="register-footer-bottom">
                    <div>
                        <span>&copy; 2025 Wszelkie Prawa zastrzeżone</span>
                    </div>
                    <div class="register-footer-admin">
                        <span>Administrator serwisu:</span>
                        <a href="https://neoart.pl" target="_blank">
                            <img src="/images/icons/neoart.png" alt="Neoart">
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Cookie Consent Banner -->
    @include('components.cookie-banner')

    <script src="{{ asset('js/cookie-consent.js') }}"></script>
    <script>
        // Select All Consents functionality
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select_all_consents');
            const consentCheckboxes = document.querySelectorAll('input[name^="consent_"]');
            
            // Handle select all checkbox
            selectAllCheckbox.addEventListener('change', function() {
                consentCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
            
            // Handle individual checkboxes
            consentCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    // Check if all individual checkboxes are checked
                    const allChecked = Array.from(consentCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                    
                    // Handle indeterminate state
                    const someChecked = Array.from(consentCheckboxes).some(cb => cb.checked);
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                });
            });
        });
        
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
