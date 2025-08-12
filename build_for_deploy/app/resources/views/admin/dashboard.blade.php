@extends('layouts.app')

@section('content')
<style>
    html, body {
        background-image: url('/images/backgrounds/bg.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    .admin-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .admin-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .admin-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #21235F;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .admin-quick-action {
        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        color: white !important;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .admin-quick-action:hover {
        background: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
        transform: translateY(-2px);
        color: white !important;
        text-decoration: none;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 1.5rem;
        transition: transform 0.3s ease;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-label {
        color: #374151;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .actions-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .actions-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .action-button {
        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        color: white !important;
        padding: 1rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        display: block;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .action-button:hover {
        transform: translateY(-2px);
        color: white !important;
        text-decoration: none;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .action-button.green { 
        background: linear-gradient(135deg, #10B981 0%, #059669 100%) !important; 
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    .action-button.purple { 
        background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important; 
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
    }
    .action-button.yellow { 
        background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%) !important; 
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    .action-button.red { 
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%) !important; 
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .recent-activity {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .activity-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .activity-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #21235F;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .activity-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-name {
        font-weight: 600;
        color: #21235F;
        margin-bottom: 0.25rem;
    }

    .activity-detail {
        font-size: 0.85rem;
        color: #6B7280;
    }

    .activity-time {
        font-size: 0.85rem;
        color: #6B7280;
    }

    @media (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .admin-title {
            font-size: 2rem;
        }
    }
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1 class="admin-title">Panel Administracyjny</h1>
        <a href="{{ route('admin.courses') }}" class="admin-quick-action">
            📚 Zarządzaj kursami
        </a>
    </div>

    <div class="admin-content">
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%); color: white;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="stat-number">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Użytkownicy</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="stat-number">{{ $stats['total_courses'] }}</div>
                <div class="stat-label">Kursy</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="stat-number">{{ $stats['total_lessons'] }}</div>
                <div class="stat-label">Lekcje</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: white;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-number">{{ $stats['total_certificates'] }}</div>
                <div class="stat-label">Certyfikaty</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="actions-section">
            <h3 class="actions-title">Szybkie akcje</h3>
            <div class="actions-grid">
                <a href="{{ route('admin.courses.create') }}" class="action-button">
                    ➕ Dodaj nowy kurs
                </a>
                <a href="{{ route('admin.courses') }}" class="action-button">
                    📚 Zarządzaj kursami
                </a>
                <a href="{{ route('admin.users') }}" class="action-button green">
                    👥 Zarządzaj użytkownikami
                </a>
                <a href="{{ route('admin.instructors.index') }}" class="action-button purple">
                    👨‍🏫 Zarządzaj wykładowcami
                </a>
                <a href="{{ route('admin.statistics') }}" class="action-button yellow">
                    📊 Statystyki
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <!-- Recent Users -->
            <div class="activity-card">
                <h3 class="activity-title">Ostatni użytkownicy</h3>
                @if($stats['recent_users']->count() > 0)
                    @foreach($stats['recent_users'] as $user)
                        <div class="activity-item">
                            <div>
                                <div class="activity-name">{{ $user->name }}</div>
                                <div class="activity-detail">{{ $user->email }}</div>
                            </div>
                            <div class="activity-time">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="activity-detail">Brak nowych użytkowników</p>
                @endif
            </div>

            <!-- Recent Courses -->
            <div class="activity-card">
                <h3 class="activity-title">Ostatnie kursy</h3>
                @if($stats['recent_courses']->count() > 0)
                    @foreach($stats['recent_courses'] as $course)
                        <div class="activity-item">
                            <div>
                                <div class="activity-name">{{ $course->title }}</div>
                                <div class="activity-detail">{{ $course->lessons->count() }} lekcji</div>
                            </div>
                            <div class="activity-time">
                                {{ $course->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="activity-detail">Brak nowych kursów</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
