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
        max-width: 800px;
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

    <!-- Contact Content -->
    <div class="contact-content">
        <p class="contact-text">
            Masz pytania dotyczące naszych kursów? Skontaktuj się z nami, aby uzyskać szczegółowe informacje o szkoleniach, zapisach i punktach edukacyjnych.
        </p>
        <p class="contact-text">
            Możesz też porozmawiać ze swoim przedstawicielem firmy <span class="company-highlight">Lek‑am</span>, który udzieli Ci potrzebnych informacji i udzieli wsparcia w korzystaniu z serwisu.
        </p>
    </div>
</div>
@endsection