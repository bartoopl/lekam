<nav x-data="{ open: false }" class="navbar-container">
    <!-- Primary Navigation Menu -->
    <div class="navbar">
        <div class="navbar-content">
            <!-- Logo -->
            <div class="navbar-brand">
                <a href="{{ route('home') }}" class="logo-container">
                    <img src="{{ asset('images/logos/logo.svg') }}" alt="Lekam Akademia" class="logo-icon">
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="navbar-links">
                <a href="{{ route('home') }}#about" class="nav-link">O nas</a>
                <a href="{{ route('courses') }}" class="nav-link">Szkolenia</a>
            </div>

            <!-- Account Buttons -->
            <div class="navbar-actions">
                @auth
                    <div class="auth-buttons">
                        @if(auth()->user()->isAdmin() || auth()->user()->email === 'admin@admin.com' || auth()->user()->user_type === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="admin-button">Panel Admin</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="account-button">
                            Moje konto
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="logout-button">
                                Wyloguj
                            </button>
                        </form>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="login-button">
                            Zaloguj
                        </a>
                        <a href="{{ route('register') }}" class="register-button">
                            Zarejestruj
                        </a>
                    </div>
                @endauth
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
            transition: all 0.3s ease;
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
            gap: 2rem;
            margin-left: auto;
            margin-right: 2rem;
        }

        .nav-link {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            color: #374151 !important;
            text-decoration: none;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #21235F !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: #21235F;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
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
        
        .account-button {
            background: linear-gradient(135deg, #21235F 0%, #3B82F6 100%) !important;
            color: white !important;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .account-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        .login-button {
            background: transparent !important;
            color: #21235F !important;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid #21235F !important;
        }
        
        .login-button:hover {
            background: #21235F;
            color: white;
            transform: translateY(-2px);
        }
        
        .register-button {
            background: linear-gradient(135deg, #21235F 0%, #3B82F6 100%) !important;
            color: white !important;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        .logout-button {
            background: transparent !important;
            color: #DC2626 !important;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid #DC2626 !important;
            cursor: pointer;
        }
        
        .logout-button:hover {
            background: #DC2626;
            color: white;
            transform: translateY(-2px);
        }
        
        .logout-form {
            margin: 0;
        }
        
        .admin-button {
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%) !important;
            color: white !important;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }
        
        .admin-button:hover {
            background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
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
        @media (max-width: 768px) {
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
        // Sticky navbar behavior
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-container');
            
            if (window.scrollY > 50) {
                navbar.classList.add('sticky');
            } else {
                navbar.classList.remove('sticky');
            }
        });
    </script>
</nav>
