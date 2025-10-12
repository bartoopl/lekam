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

    <title>Polityka prywatności - LEK-AM Akademia</title>

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
            text-align: center;
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
            <h1 class="page-title">Polityka prywatności</h1>

            <div class="content">
                <p class="intro">
                    Dbamy o Twoją prywatność. Poniżej wyjaśniamy, jak przetwarzamy dane osobowe użytkowników Platformy e-learningowej AkademiaLekam.pl oraz jak korzystamy z plików cookies.
                </p>

                <h2>1. Administrator danych</h2>
                <p>
                    <strong>Grupa NeoArt</strong> ul. Puławska 314, 02-819 Warszawa – dalej „Administrator"<br>
                    <strong>Kontakt w sprawach danych osobowych:</strong> office@neoart.pl
                </p>

                <h2>2. Niezależni administratorzy – marketing</h2>
                <p>
                    <strong>Przedsiębiorstwo Farmaceutyczne LEK-AM Sp. z o.o.</strong> (ul. Ostrzykowizna 14A, 05-170 Zakroczym) – niezależny administrator dla celów marketingowych na podstawie odrębnej, dobrowolnej zgody (osobny checkbox).<br>
                    <strong>Kontakt w sprawach danych osobowych:</strong> iod@lekam.pl
                </p>

                <h2>3. Zakres i cele przetwarzania</h2>
                <p>
                    Przetwarzamy Twoje dane w związku z funkcjonowaniem Platformy i świadczeniem usług edukacyjnych (szkolenia, webinary, testy, certyfikaty).
                </p>
                <p><strong>Cele i podstawy prawne:</strong></p>
                <ul>
                    <li><strong>Założenie i obsługa konta, udostępnienie treści Platformy</strong> (szkolenia, webinary, testy, certyfikaty, wsparcie techniczne) – art. 6 ust. 1 lit. b RODO (niezbędne do wykonania umowy o świadczenie usług drogą elektroniczną).</li>
                    <li><strong>Komunikacja operacyjna</strong> (np. potwierdzenia rejestracji, informacje o dostępie do szkolenia, zmiany regulaminu) – art. 6 ust. 1 lit. b i/lub lit. c RODO.</li>
                    <li><strong>Prowadzenie statystyk, zapewnienie bezpieczeństwa i ulepszanie usług</strong> (logi, zdarzenia, analiza ruchu w ujęciu zagregowanym) – art. 6 ust. 1 lit. f RODO (prawnie uzasadniony interes Administratora).</li>
                    <li><strong>Marketing bezpośredni NeoArt</strong> (e-mail) – wyłącznie na podstawie Twojej zgody: art. 6 ust. 1 lit. a RODO + uŚUDE / art. 172 PT (osobne checkboxy).</li>
                    <li><strong>Marketing bezpośredni LEK-AM</strong> (e-mail) – wyłącznie na podstawie Twojej zgody: art. 6 ust. 1 lit. a RODO + uŚUDE / art. 172 PT (osobne checkboxy).</li>
                    <li><strong>Ustalenie, dochodzenie lub obrona roszczeń</strong> – art. 6 ust. 1 lit. f RODO.</li>
                </ul>
                <p><strong>Dobrowolność podania danych:</strong></p>
                <p>
                    Podanie danych jest dobrowolne, jednak niepodanie danych niezbędnych do rejestracji/logowania może uniemożliwić korzystanie z Platformy lub skutkować ograniczeniami w dostępie do treści (np. brak możliwości udziału w webinarze, przejścia testu, pobrania certyfikatu).
                </p>

                <h2>4. Zakres danych</h2>
                <p>
                    W szczególności: imię, nazwisko, e-mail, hasło (zahashowane), informacje o aktywności edukacyjnej (postępy, zaliczenia testów, certyfikaty), miejsce pracy / nr PWZ*, logi systemowe (adres IP, identyfikatory zdarzeń).
                </p>

                <h2>5. Odbiorcy danych (procesorzy/podmioty przetwarzające)</h2>
                <p>
                    Wspierają nas zaufani dostawcy działający na nasze zlecenie: dostawca hostingu/chmury, system mailingowy, narzędzia webinarowe/streamingowe, system zgłoszeń helpdesk, podmioty utrzymaniowe/serwisowe, narzędzia analityczne/funkcjonalne (np. reCAPTCHA, system ankiet).
                </p>

                <h2>6. Okres przechowywania</h2>
                <p>Przechowujemy dane:</p>
                <ul>
                    <li><strong>konto i treści edukacyjne</strong> – przez czas trwania umowy (posiadanie konta), a po jej zakończeniu przez okres niezbędny do rozliczeń i obrony roszczeń (do 6 lat lub tyle, ile wymagają przepisy),</li>
                    <li><strong>logi techniczne</strong> – co do zasady do 12 miesięcy,</li>
                    <li><strong>marketing (NeoArt/LEK-AM)</strong> – do czasu wycofania zgody, a następnie w ograniczonym zakresie w celu wykazania faktu jej udzielenia (rozliczalność).</li>
                </ul>

                <h2>7. Twoje prawa</h2>
                <p>
                    Masz prawo do: dostępu, sprostowania, usunięcia, ograniczenia, przeniesienia, sprzeciwu (gdy podstawą jest art. 6 ust. 1 lit. f). Jeśli podstawą jest zgoda, możesz ją wycofać w dowolnym momencie – bez wpływu na zgodność z prawem przetwarzania sprzed wycofania.
                </p>
                <p><strong>Skontaktuj się:</strong><br>
                    NeoArt&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;office@neoart.pl<br>
                    LEK-AM&nbsp;&nbsp;&nbsp;&nbsp;iod@lekam.pl
                </p>

                <h2>8. Przekazywanie poza EOG</h2>
                <p>
                    Co do zasady przetwarzamy dane w EOG. Jeśli wyjątkowo dojdzie do transferu poza EOG, zastosujemy mechanizmy z art. 46 RODO (np. standardowe klauzule umowne) i poinformujemy Cię o tym.
                </p>

                <h2>9. Zabezpieczenia</h2>
                <p>
                    Stosujemy środki techniczne i organizacyjne adekwatne do ryzyka (art. 32 RODO), m.in. szyfrowanie transmisji (TLS/HTTPS), kontrolę dostępu, rejestrowanie zdarzeń, regularne aktualizacje i kopie zapasowe.
                </p>

                <h2>10. Marketing i komunikacja</h2>
                <ul>
                    <li><strong>Marketing NeoArt:</strong> wyłącznie po Twojej odrębnej zgodzie (osobny checkbox) – e-mail</li>
                    <li><strong>Marketing LEK-AM:</strong> wyłącznie po Twojej odrębnej zgodzie (osobny checkbox) – e-mail</li>
                </ul>
                <p>Zgody są dobrowolne i nie są warunkiem korzystania z Platformy.</p>

                <h2>11. Profilowanie</h2>
                <p>
                    Możemy prowadzić nieszkodliwe profilowanie w celu dopasowania treści edukacyjnych (np. rekomendacje szkoleń) – bez skutków prawnych wobec Ciebie i bez istotnego wpływu na Twoją sytuację (art. 6 ust. 1 lit. f RODO).
                </p>
                <p>
                    Profilowanie marketingowe (np. z wykorzystaniem cookies) odbywa się tylko za Twoją zgodą na cookies marketingowe i/lub zgody marketingowe.
                </p>

                <div style="margin-top: 2rem; padding: 1rem; background: #f3f4f6; border-radius: 8px;">
                    <p style="font-size: 0.9rem; color: #6b7280; margin: 0;">
                        <strong>Data ostatniej aktualizacji:</strong> 07.10.2025<br>
                        <strong>Wersja polityki prywatności:</strong> 1.0
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cookie Consent Banner -->
    @include('components.cookie-banner')

    <script src="{{ asset('js/cookie-consent.js') }}"></script>
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