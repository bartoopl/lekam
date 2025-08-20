<nav class="navbar-container">
    <!-- Primary Navigation Menu -->
    <div class="navbar">
        <div class="navbar-content">
            <!-- Logo -->
            <div class="navbar-brand">
                <a href="{{ route('home') }}" class="logo-container">
                    <img src="{{ asset('images/logos/logo.svg') }}" alt="Lekam Akademia" class="logo-icon">
                </a>
            </div>

            <!-- Navigation Links (Desktop) -->
            <div class="navbar-links desktop-only">
                <a href="{{ route('home') }}#about" class="nav-link">O nas</a>
                <a href="{{ route('courses') }}" class="nav-link">Szkolenia</a>
                <a href="{{ route('contact') }}" class="nav-link">Kontakt</a>
            </div>

            <!-- Account Buttons (Desktop) -->
            <div class="navbar-actions desktop-only">
                @auth
                    <div class="auth-buttons">
                        @if(auth()->user()->isAdmin() || auth()->user()->email === 'admin@admin.com' || auth()->user()->user_type === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">Panel Admin</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            Moje konto
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="btn btn-outlined">
                                Wyloguj
                            </button>
                        </form>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-secondary">
                            Zaloguj
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Zarejestruj
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="mobile-menu-button mobile-only" onclick="toggleMobileMenu()">
                <div class="hamburger-lines" id="hamburger-lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-menu-content">
                <!-- Close Button -->
                <div class="mobile-menu-close">
                    <button onclick="closeMobileMenu()" class="mobile-close-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.3 5.71c-.39-.39-1.02-.39-1.41 0L12 10.59 7.11 5.7c-.39-.39-1.02-.39-1.41 0s-.39 1.02 0 1.41L10.59 12 5.7 16.89c-.39.39-.39 1.02 0 1.41s1.02.39 1.41 0L12 13.41l4.89 4.88c.39.39 1.02.39 1.41 0s.39-1.02 0-1.41L13.41 12l4.88-4.89c.39-.39.39-1.02.01-1.4z"/>
                        </svg>
                    </button>
                </div>
                <!-- Navigation Links -->
                <div class="mobile-nav-links">
                    <a href="{{ route('home') }}#about" class="mobile-nav-link" onclick="closeMobileMenu()">O nas</a>
                    <a href="{{ route('courses') }}" class="mobile-nav-link" onclick="closeMobileMenu()">Szkolenia</a>
                    <a href="{{ route('contact') }}" class="mobile-nav-link" onclick="closeMobileMenu()">Kontakt</a>
                </div>

                <!-- Account Buttons -->
                <div class="mobile-auth-buttons">
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->email === 'admin@admin.com' || auth()->user()->user_type === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger" onclick="closeMobileMenu()">Panel Admin</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="btn btn-primary" onclick="closeMobileMenu()">
                            Moje konto
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mobile-logout-form">
                            @csrf
                            <button type="submit" class="btn btn-outlined" onclick="closeMobileMenu()">
                                Wyloguj
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-secondary" onclick="closeMobileMenu()">
                            Zaloguj
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary" onclick="closeMobileMenu()">
                            Zarejestruj
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <style>
        .navbar-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: transform 0.3s ease;
            width: 100%;
        }
        
        .navbar-container.navbar-hidden {
            transform: translateY(-100%);
        }

        .navbar {
            width: 90%;
            max-width: 1920px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.95) !important;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .navbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2rem;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
            text-decoration: none;
            gap: 12px;
        }

        .logo-icon {
            width: 120px;
            height: auto;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: auto;
            margin-right: 2rem;
        }

        .nav-link {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            color: #374151 !important;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            border: 2px solid transparent;
        }

        .nav-link:hover {
            color: #21235F !important;
            border: 2px solid #21235F;
            background: rgba(33, 35, 95, 0.05);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
        }
        
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        /* Override button styles ONLY for navbar context */
        .navbar-container .auth-buttons .btn {
            padding: 0.75rem 1.5rem !important;
            font-size: 0.9rem !important;
            border-radius: 16px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            margin: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            cursor: pointer !important;
            white-space: nowrap !important;
            user-select: none !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        .navbar-container .auth-buttons .btn:hover {
            transform: translateY(-2px) !important;
        }
        
        /* Specific button styles ONLY for navbar */
        .navbar-container .auth-buttons .btn-primary {
            background-color: #21235F !important;
            color: white !important;
            border: 2px solid #21235F !important;
        }
        
        .navbar-container .auth-buttons .btn-primary:hover {
            background-color: #1a1a4d !important;
            border-color: #1a1a4d !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(33, 35, 95, 0.3) !important;
        }
        
        .navbar-container .auth-buttons .btn-secondary {
            background-color: transparent !important;
            color: #21235F !important;
            border: 2px solid #21235F !important;
        }
        
        .navbar-container .auth-buttons .btn-secondary:hover {
            background-color: #21235F !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(33, 35, 95, 0.3) !important;
        }
        
        .navbar-container .auth-buttons .btn-outlined {
            background-color: transparent !important;
            color: #21235F !important;
            border: 2px solid #21235F !important;
        }
        
        .navbar-container .auth-buttons .btn-outlined:hover {
            background-color: #21235F !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(33, 35, 95, 0.3) !important;
        }
        
        .navbar-container .auth-buttons .btn-danger {
            background-color: #EF4444 !important;
            color: white !important;
            border: 2px solid #EF4444 !important;
        }
        
        .navbar-container .auth-buttons .btn-danger:hover {
            background-color: #DC2626 !important;
            border-color: #DC2626 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        }
        
        .logout-form {
            margin: 0;
        }

        /* Sticky behavior */
        .navbar-container.sticky .navbar {
            width: 100%;
            margin: 0;
            border-radius: 0;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-container.sticky .navbar-content {
            padding: 1rem 2rem;
        }

        /* Mobile responsive */
        .desktop-only {
            display: flex;
        }
        
        .mobile-only {
            display: none;
        }
        
        /* Mobile Menu Button */
        .mobile-menu-button {
            cursor: pointer;
            padding: 8px;
            z-index: 1001;
            position: relative;
        }
        
        .hamburger-lines {
            width: 24px;
            height: 18px;
            position: relative;
            transform: rotate(0deg);
            transition: .5s ease-in-out;
        }
        
        .hamburger-lines span {
            display: block;
            position: absolute;
            height: 3px;
            width: 100%;
            background: #21235F;
            border-radius: 2px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }
        
        .hamburger-lines span:nth-child(1) {
            top: 0px;
        }
        
        .hamburger-lines span:nth-child(2) {
            top: 7px;
        }
        
        .hamburger-lines span:nth-child(3) {
            top: 14px;
        }
        
        .hamburger-lines.open span:nth-child(1) {
            top: 7px;
            transform: rotate(135deg);
        }
        
        .hamburger-lines.open span:nth-child(2) {
            opacity: 0;
            left: -60px;
        }
        
        .hamburger-lines.open span:nth-child(3) {
            top: 7px;
            transform: rotate(-135deg);
        }
        
        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            z-index: 1002;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            visibility: hidden;
        }
        
        .mobile-menu.open {
            transform: translateX(0);
            visibility: visible;
        }
        
        .mobile-menu-content {
            background: white;
            width: 280px;
            height: 100%;
            padding: 2rem;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .mobile-menu-close {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 2rem;
        }
        
        .mobile-close-button {
            background: transparent;
            border: none;
            cursor: pointer;
            color: #374151;
            transition: color 0.3s ease;
            padding: 0.5rem;
        }
        
        .mobile-close-button:hover {
            color: #21235F;
        }
        
        .mobile-nav-links {
            margin-bottom: 2rem;
        }
        
        .mobile-nav-link {
            display: block;
            padding: 0.7rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            color: #374151;
            text-decoration: none;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.3s ease;
            margin: 0.3rem 0;
            border-radius: 20px;
            border: 2px solid transparent;
        }
        
        .mobile-nav-link:hover {
            color: #21235F;
            border: 2px solid #21235F;
            background: rgba(33, 35, 95, 0.05);
            border-bottom: 2px solid #21235F;
        }
        
        .mobile-auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        /* Mobile button overrides ONLY for navbar */
        .navbar-container .mobile-auth-buttons .btn {
            padding: 1rem 1.5rem !important;
            font-size: 1rem !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            text-align: center !important;
            transition: all 0.3s ease !important;
            margin: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            cursor: pointer !important;
            white-space: nowrap !important;
            user-select: none !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        .mobile-logout-form {
            margin: 0;
        }
        
        /* Specific mobile button styles ONLY for navbar */
        .navbar-container .mobile-auth-buttons .btn-primary {
            background-color: #21235F !important;
            color: white !important;
            border: 2px solid #21235F !important;
        }
        
        .navbar-container .mobile-auth-buttons .btn-primary:hover {
            background-color: #1a1a4d !important;
            border-color: #1a1a4d !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(33, 35, 95, 0.3) !important;
        }
        
        .navbar-container .mobile-auth-buttons .btn-secondary {
            background-color: transparent !important;
            color: #21235F !important;
            border: 2px solid #21235F !important;
        }
        
        .navbar-container .mobile-auth-buttons .btn-secondary:hover {
            background-color: #21235F !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(33, 35, 95, 0.3) !important;
        }
        
        .navbar-container .mobile-auth-buttons .btn-outlined {
            background-color: transparent !important;
            color: #21235F !important;
            border: 2px solid #21235F !important;
        }
        
        .navbar-container .mobile-auth-buttons .btn-outlined:hover {
            background-color: #21235F !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(33, 35, 95, 0.3) !important;
        }
        
        .navbar-container .mobile-auth-buttons .btn-danger {
            background-color: #EF4444 !important;
            color: white !important;
            border: 2px solid #EF4444 !important;
        }
        
        .navbar-container .mobile-auth-buttons .btn-danger:hover {
            background-color: #DC2626 !important;
            border-color: #DC2626 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        }

        @media (max-width: 768px) {
            .desktop-only {
                display: none;
            }
            
            .mobile-only {
                display: flex;
            }
            
            .navbar {
                width: 95%;
                margin: 10px auto;
            }
            .navbar-container.sticky .navbar {
                width: 100%;
                margin: 0;
            }
            .navbar-container.sticky .navbar-content {
                padding: 1rem 1rem;
            }
        }
    </style>

    <script>
        // Auto-hide navbar functionality
        let lastScrollTop = 0;
        let isNavbarVisible = true;
        let hideTimer = null;

        function showNavbar() {
            const navbar = document.querySelector('.navbar-container');
            navbar.classList.remove('navbar-hidden');
            isNavbarVisible = true;
            
            // Clear any existing hide timer
            if (hideTimer) {
                clearTimeout(hideTimer);
                hideTimer = null;
            }
        }

        function hideNavbar() {
            const navbar = document.querySelector('.navbar-container');
            navbar.classList.add('navbar-hidden');
            isNavbarVisible = false;
        }

        // Scroll behavior - hide when scrolling down, show when scrolling up
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-container');
            const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add sticky class for visual changes
            if (currentScrollTop > 50) {
                navbar.classList.add('sticky');
            } else {
                navbar.classList.remove('sticky');
            }
            
            // Auto-hide logic
            if (currentScrollTop > lastScrollTop && currentScrollTop > 100) {
                // Scrolling down - hide navbar
                if (isNavbarVisible) {
                    hideNavbar();
                }
            } else if (currentScrollTop < lastScrollTop) {
                // Scrolling up - show navbar
                if (!isNavbarVisible) {
                    showNavbar();
                }
            }
            
            lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
        });

        // Mouse movement behavior - show navbar when mouse is near top
        document.addEventListener('mousemove', function(e) {
            // Show navbar when mouse is within 100px from top of screen
            if (e.clientY <= 100) {
                if (!isNavbarVisible) {
                    showNavbar();
                }
                
                // Set timer to hide navbar after 3 seconds of no mouse movement at top
                if (hideTimer) {
                    clearTimeout(hideTimer);
                }
                hideTimer = setTimeout(() => {
                    if (window.pageYOffset > 100 && e.clientY > 100) {
                        hideNavbar();
                    }
                }, 3000);
            }
        });

        // Always show navbar when at top of page
        window.addEventListener('scroll', function() {
            if (window.pageYOffset <= 50) {
                showNavbar();
            }
        });

        // Mobile menu toggle functions
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerLines = document.getElementById('hamburger-lines');
            
            mobileMenu.classList.toggle('open');
            hamburgerLines.classList.toggle('open');
        }

        function closeMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerLines = document.getElementById('hamburger-lines');
            
            mobileMenu.classList.remove('open');
            hamburgerLines.classList.remove('open');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerButton = document.querySelector('.mobile-menu-button');
            
            if (mobileMenu && mobileMenu.classList.contains('open')) {
                if (!mobileMenu.contains(event.target) && !hamburgerButton.contains(event.target)) {
                    closeMobileMenu();
                }
            }
        });
    </script>
</nav>
