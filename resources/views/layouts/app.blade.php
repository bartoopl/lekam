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

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Backup: Original video controller (uncomment to test timer) -->
        <!-- <script src="{{ asset('js/video-controller-backup.js') }}?v={{ time() }}"></script> -->
        
        <!-- Video.js -->
        <link href="https://vjs.zencdn.net/8.12.0/video-js.css" rel="stylesheet" />
        <link href="{{ asset('css/videojs-custom.css') }}?v={{ time() }}" rel="stylesheet" />
        <script src="https://vjs.zencdn.net/8.12.0/video.min.js"></script>
        <script src="{{ asset('js/video-controller-videojs.js') }}?v={{ time() }}"></script>
        
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
        
        <style>
            /* Custom video player styles - no dark overlays */
            #lesson-video {
                filter: none !important;
                -webkit-filter: none !important;
                background: #000 !important;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            }
            
            /* Remove any dark overlays from video */
            video {
                filter: none !important;
                -webkit-filter: none !important;
                background: #000 !important;
            }
            
            /* Custom slider styles */
            .slider {
                -webkit-appearance: none;
                appearance: none;
                background: transparent;
                cursor: pointer;
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="background-image: url('{{ asset('images/backgrounds/bg.jpg') }}') !important; background-size: cover !important; background-position: center !important; background-attachment: fixed !important; background-repeat: no-repeat !important; background-color: transparent !important; min-height: 100vh;">
        <div class="min-h-screen" style="background: transparent !important;">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="shadow" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); margin-top: 120px;">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" style="margin-top: 140px;">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" style="margin-top: 140px;">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" style="margin-top: 140px;">
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('info') }}</span>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main style="margin-top: 120px;">
                @yield('content')
            </main>
        </div>

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

            // Also ensure it's available after DOMContentLoaded
            document.addEventListener('DOMContentLoaded', function() {
                // Make sure openCookieModal is still available
                if (typeof window.openCookieModal === 'undefined') {
                    window.openCookieModal = function() {
                        if (window.CookieConsent && window.CookieConsent.showModal) {
                            window.CookieConsent.showModal();
                        }
                    };
                }
            });
        </script>
    </body>
</html>
