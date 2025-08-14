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
        padding: 2rem;
        margin-bottom: 2rem;
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
        margin-top: 2rem;
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
@endsection