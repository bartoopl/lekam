@extends('layouts.app')

@section('content')
<style>
    html, body {
        background-image: url('/images/backgrounds/bg.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        padding-top: 20px;
    }

    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .contact-header {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .contact-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 1.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .contact-content {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .contact-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
        margin-bottom: 1.5rem;
    }

    .company-highlight {
        color: #21235F;
        font-weight: 600;
    }

    .breadcrumbs {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        font-size: 0.9rem;
        color: #666;
    }

    .breadcrumb-item {
        color: #21235F;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-item:hover {
        color: #3B82F6;
    }

    .breadcrumb-separator {
        color: #999;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-top: 0;
    }

    .contact-info {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 2rem;
    }

    .info-section {
        margin-bottom: 2rem;
    }

    .info-section:last-child {
        margin-bottom: 0;
    }

    .info-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #21235F;
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        color: #333;
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-icon {
        width: 20px;
        height: 20px;
        margin-right: 0.75rem;
        fill: #21235F;
    }

    @media (max-width: 768px) {
        .contact-container {
            padding: 1rem;
        }
        
        .contact-title {
            font-size: 2rem;
        }
        
        .contact-text {
            font-size: 1rem;
        }

        .contact-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .info-title {
            font-size: 1.1rem;
        }
    }
</style>

<div class="contact-container">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <a href="{{ route('home') }}" class="breadcrumb-item">Strona główna</a>
        <span class="breadcrumb-separator">›</span>
        <span>Kontakt</span>
    </div>

    <!-- Contact Header -->
    <div class="contact-header">
        <h1 class="contact-title">Kontakt</h1>
    </div>

    <!-- Contact Grid -->
    <div class="contact-grid">
        <!-- Left Column - Contact Content -->
        <div class="contact-content">
            <p class="contact-text">
                Masz pytania dotyczące naszych kursów? Skontaktuj się z nami, aby uzyskać szczegółowe informacje o szkoleniach, zapisach i punktach edukacyjnych.
            </p>
            <p class="contact-text">
                Możesz też porozmawiać ze swoim przedstawicielem firmy <span class="company-highlight">Lek‑am</span>, który udzieli Ci potrzebnych informacji i udzieli wsparcia w korzystaniu z serwisu.
            </p>
        </div>

        <!-- Right Column - Contact Info -->
        <div class="contact-info">
            <!-- LEK-AM Information -->
            <div class="info-section">
                <h3 class="info-title">Informacja LEK-AM</h3>
                <div class="contact-item">
                    <svg class="contact-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>
                    </svg>
                    888 888 888
                </div>
                <div class="contact-item">
                    <svg class="contact-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                    </svg>
                    info@info.pl
                </div>
            </div>

            <!-- Technical Support -->
            <div class="info-section">
                <h3 class="info-title">Wsparcie techniczne serwisu</h3>
                <div class="contact-item">
                    <svg class="contact-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                    </svg>
                    info@info.pl
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<style>
/* Footer */
.footer * {
    background: transparent !important;
    background-color: transparent !important;
    backdrop-filter: none !important;
    border: none !important;
    border-radius: 0 !important;
}

.footer {
    background-image: url('/images/backgrounds/wave.png') !important;
    background-size: cover !important;
    background-position: center !important;
    background-color: #21235F !important;
    background-blend-mode: overlay !important;
    position: relative !important;
    color: white !important;
    padding: 4rem 0 2rem 0 !important;
}

.footer::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: linear-gradient(135deg, #21235F 0%, #2a2d7a 100%) !important;
    opacity: 0.2 !important;
    z-index: 1 !important;
}

.footer-content {
    max-width: 1200px !important;
    margin: 0 auto !important;
    padding: 0 2rem !important;
    display: grid !important;
    grid-template-columns: 2fr 1fr 1fr !important;
    gap: 3rem !important;
    position: relative !important;
    z-index: 2 !important;
    background: none !important;
    backdrop-filter: none !important;
    border: none !important;
    border-radius: 0 !important;
}

.footer-left {
    display: flex !important;
    flex-direction: column !important;
    gap: 1rem !important;
    background: transparent !important;
    background-color: transparent !important;
    backdrop-filter: none !important;
    border: none !important;
    border-radius: 0 !important;
}

.footer-logo {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    background: transparent !important;
    background-color: transparent !important;
    backdrop-filter: none !important;
    border: none !important;
    border-radius: 0 !important;
}

.footer-logo-icon {
    width: 120px !important;
    height: 120px !important;
    filter: brightness(0) invert(1) !important;
}

.footer-description {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 400 !important;
    font-size: 1rem !important;
    line-height: 1.6 !important;
    color: rgba(255, 255, 255, 0.9) !important;
    margin: 0 !important;
}

.footer-center,
.footer-right {
    display: flex !important;
    flex-direction: column !important;
    gap: 1rem !important;
    background: transparent !important;
    background-color: transparent !important;
    backdrop-filter: none !important;
    border: none !important;
    border-radius: 0 !important;
}

.footer-section-title {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600 !important;
    font-size: 1.1rem !important;
    color: white !important;
    margin: 0 !important;
}

.footer-links {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 0.5rem !important;
    background: transparent !important;
    background-color: transparent !important;
    backdrop-filter: none !important;
    border: none !important;
    border-radius: 0 !important;
}

.footer-link {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 400 !important;
    font-size: 0.9rem !important;
    color: rgba(255, 255, 255, 0.8) !important;
    text-decoration: none !important;
    transition: color 0.3s ease !important;
}

.footer-link:hover {
    color: white !important;
}

.footer-bottom {
    max-width: 1200px !important;
    margin: 0 auto !important;
    padding: 2rem 2rem 0 2rem !important;
    border-top: 1px solid rgba(255, 255, 255, 0.2) !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    position: relative !important;
    z-index: 2 !important;
}

.footer-bottom-left,
.footer-bottom-right {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 400 !important;
    font-size: 0.9rem !important;
    color: rgba(255, 255, 255, 0.8) !important;
}

.footer-admin-link {
    color: rgba(255, 255, 255, 0.8) !important;
    text-decoration: none !important;
    transition: color 0.3s ease !important;
}

.footer-admin-link:hover {
    color: white !important;
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
        text-align: center !important;
    }
    
    .footer-bottom {
        flex-direction: column !important;
        gap: 1rem !important;
        text-align: center !important;
    }
}
</style>

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
                <li><a href="{{ route('terms') }}" class="footer-link">Regulamin Serwisu</a></li>
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
    </div>
    
    <div class="footer-bottom">
        <div class="footer-bottom-left">
            <div style="display: flex; align-items: center;">
                <span>&copy; 2025 Wszelkie Prawa zastrzeżone</span>
                <img src="/images/icons/lekam.png" alt="Lekam" style="height: 24px; margin-left: 8px;">
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
@endsection