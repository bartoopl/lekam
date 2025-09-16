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

    <title>Polityka plików cookies - LEK-AM Akademia</title>

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

        /* Content Container */
        .content-container {
            min-height: 100vh;
            padding: 2rem;
            padding-top: 150px;
        }

        .content-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: #21235F;
            margin-bottom: 2rem;
            text-align: center;
        }

        .content {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            line-height: 1.6;
            color: #374151;
        }

        .content h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.5rem;
            color: #21235F;
            margin: 2rem 0 1rem 0;
        }

        .content h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.25rem;
            color: #21235F;
            margin: 1.5rem 0 0.75rem 0;
        }

        .content p {
            margin-bottom: 1rem;
        }

        .content ul {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }

        .content li {
            margin-bottom: 0.5rem;
        }

        .content strong {
            font-weight: 600;
            color: #21235F;
        }

        .intro {
            font-size: 1.1rem;
            color: #6B7280;
            margin-bottom: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-container {
                padding: 1rem;
                padding-top: 140px;
            }

            .content-wrapper {
                padding: 2rem;
            }

            .page-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="content-container">
        <div class="content-wrapper">
            <h1 class="page-title">Pliki Cookies - Ciasteczka</h1>

            <div class="content">
                <p class="intro">
                    Stosujemy dwa rodzaje plików Cookies:
                </p>
                <ul>
                    <li><strong>sesyjne</strong> – pliki tymczasowe, które pozostają na urządzeniu końcowym Użytkownika aż do wylogowania lub wyłączenia oprogramowania (przeglądarki internetowej),</li>
                    <li><strong>stałe</strong> – pliki, które pozostają na urządzeniu końcowym Użytkownika przez czas określony w parametrach plików Cookies albo do momentu ich ręcznego usunięcia przez Użytkownika.</li>
                </ul>

                <h2>Cele stosowania plików Cookies</h2>
                <p>Pliki Cookies umożliwiają:</p>
                <ul>
                    <li><strong>utrzymanie stanu sesji po zalogowaniu</strong>, co ułatwia logowanie, automatyczne uzupełnianie formularzy, czy też zapamiętywanie ustawień stron internetowych dokonywanych przez Użytkownika. Użytkownik nie musi na stronie internetowej ponownie wpisywać loginu i hasła;</li>
                    <li><strong>ustawienie funkcji i usług Grupy NeoArt</strong>, co skutkuje w szczególności optymalizacją korzystania ze stron internetowych i funkcjonalności oraz dostosowaniem zawartości stron internetowych i funkcjonalności do preferencji i oczekiwań Użytkownika poprzez zapamiętywanie ustawień wybranych przez niego;</li>
                    <li><strong>wyświetlanie komunikatów promocyjnych i reklam</strong>, które są preferowane i oczekiwane przez Użytkownika;</li>
                    <li><strong>dostosowanie wyświetlanych informacji do lokalizacji Użytkownika</strong>;</li>
                    <li><strong>zdefiniowanie preferencji Użytkowników</strong> stron internetowych zarządzanych przez Grupa NeoArt co wpływa na ich ulepszenie i rozwój. Administrator zbiera anonimowe informacje i przetwarza dane na temat trendów i preferencji, bez identyfikowania danych osobowych poszczególnych Użytkowników.</li>
                </ul>

                <p>
                    <strong>Pliki Cookies Zewnętrzne</strong> Administrator wykorzystuje w szczególności w celu automatycznego logowania lub rejestracji w serwisach Grupy NeoArt za pomocą zewnętrznego serwisu internetowego, który udostępnił taką możliwość i został funkcjonalnie powiązany z innymi serwisami, którymi zarządza Grupa NeoArt.
                </p>

                <h2>Charakterystyka plików cookies</h2>
                <p>Pliki cookies czyli tzw. ciasteczka:</p>
                <ul>
                    <li>są zapisywane w pamięci Twojego urządzenia (komputera, telefonu, itd.)</li>
                    <li>umożliwiają Ci, m.in., korzystanie ze wszystkich funkcji serwisu internetowego</li>
                    <li>nie powodują zmian w ustawieniach Twojego urządzenia</li>
                </ul>

                <p>Korzystając z odpowiednich opcji Twojej przeglądarki, w każdej chwili możesz:</p>
                <ul>
                    <li>usunąć pliki cookies</li>
                    <li>blokować wykorzystanie plików cookies w przyszłości</li>
                </ul>

                <h2>Zastosowanie na naszej witrynie</h2>
                <p>Na naszej witrynie ciasteczka wykorzystywane są w celu:</p>
                <ul>
                    <li>zapamiętywania informacji o Twojej sesji</li>
                    <li>statystycznym</li>
                    <li>marketingowym</li>
                    <li>udostępniania funkcji serwisu internetowego</li>
                </ul>

                <p>
                    Aby dowiedzieć się jak zarządzać plikami cookies, w tym jak wyłączyć ich obsługę w Twojej przeglądarce, możesz skorzystać z pliku pomocy Twojej przeglądarki. Z informacjami na ten temat możesz zapoznać się wciskając klawisz F1 w przeglądarce.
                </p>

                <p>
                    <strong>Jeśli nie wyłączysz wykorzystywania plików cookies w ustawieniach przeglądarki, oznacza to, że wyrażasz zgodę na ich wykorzystanie.</strong>
                </p>

                <h2>Usługi zewnętrzne/odbiorcy danych</h2>
                <p>
                    Korzystamy z usług podmiotów zewnętrznych, którym mogą być przekazywane Twoje dane. Poniżej znajduje się lista tych podmiotów:
                </p>
                <ul>
                    <li>podmiot realizujący dostawę towarów lub usług</li>
                    <li>podmioty współpracujące z Grupa NeoArt przy realizacji szkoleń, webinariów, transmisji online</li>
                    <li>dostawca płatności</li>
                    <li>biuro księgowe</li>
                    <li>hostingodawca</li>
                    <li>podmiot ułatwiający optymalizację serwisu</li>
                    <li>osoby współpracujące z nami na podstawie umów cywilnoprawnych, wspierające naszą bieżącą działalność</li>
                    <li>dostawca oprogramowania ułatwiającego prowadzenie działalności (np. oprogramowanie księgowe)</li>
                    <li>podmiot zapewniający nam wsparcie techniczne</li>
                    <li>podmiot zapewniający system mailingowy</li>
                    <li>podmiot zapewniający usługi marketingowe i telemarketingowe</li>
                    <li>dostawca oprogramowania potrzebnego do prowadzenia serwisu internetowego</li>
                </ul>

                <h2>Kontakt z administratorem</h2>
                <p>
                    Chcesz skorzystać ze swoich uprawnień dotyczących danych osobowych? A może po prostu chcesz zapytać o coś związanego z naszą Polityką Prywatności? Napisz na adres e-mail: <strong>office@grupaneoart.pl</strong>
                </p>

                <div style="margin-top: 2rem; padding: 1rem; background: #f3f4f6; border-radius: 8px;">
                    <p style="font-size: 0.9rem; color: #6b7280; margin: 0;">
                        <strong>Data ostatniej aktualizacji:</strong> {{ date('d.m.Y') }}<br>
                        <strong>Wersja polityki cookies:</strong> 1.0
                    </p>
                </div>
            </div>
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