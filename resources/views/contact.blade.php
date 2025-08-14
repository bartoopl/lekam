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
                <li><a href="#" class="footer-link">Regulamin Serwisu</a></li>
                <li><a href="#" class="footer-link">Polityka Prywatności</a></li>
                <li><a href="#" class="footer-link">Polityka Plików Cookies</a></li>
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

<style>
    .footer {
        background-image: url('/images/backgrounds/bg.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
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
        background: linear-gradient(135deg, #21235F 0%, #2a2d7a 100%);
        opacity: 0.2;
        z-index: 1;
    }
    
    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
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
        filter: brightness(0) invert(1);
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
    .footer-right {
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
@endsection