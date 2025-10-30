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
        max-width: 1400px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .progress-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: bold;
    }

    .user-details h2 {
        margin: 0 0 0.5rem 0;
        color: #21235F;
        font-size: 1.8rem;
    }

    .user-details p {
        margin: 0.25rem 0;
        color: #6B7280;
        font-size: 0.95rem;
    }

    .back-button {
        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-button:hover {
        background: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
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
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .stat-number.total {
        color: #6B7280;
    }

    .stat-number.completed {
        color: #10B981;
    }

    .stat-number.in-progress {
        color: #F59E0B;
    }

    .stat-label {
        color: #6B7280;
        font-size: 1rem;
        font-weight: 500;
    }

    .courses-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #E5E7EB;
    }

    .course-card {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .course-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .course-header {
        display: flex;
        justify-content: between;
        align-items: start;
        margin-bottom: 1rem;
    }

    .course-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 0.5rem;
        flex: 1;
    }

    .course-status {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        text-align: center;
        min-width: 100px;
    }

    .status-completed {
        background: #D1FAE5;
        color: #065F46;
    }

    .status-in-progress {
        background: #FEF3C7;
        color: #92400E;
    }

    .status-not-started {
        background: #F3F4F6;
        color: #6B7280;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #E5E7EB;
        border-radius: 4px;
        overflow: hidden;
        margin: 1rem 0;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3B82F6 0%, #1D4ED8 100%);
        transition: width 0.3s ease;
    }

    .lessons-list {
        margin-top: 1rem;
    }

    .lesson-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        background: #F9FAFB;
        transition: all 0.2s ease;
    }

    .lesson-item.completed {
        background: #ECFDF5;
        border-left: 4px solid #10B981;
    }

    .lesson-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #E5E7EB;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: #6B7280;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .lesson-item.completed .lesson-icon {
        background: #10B981;
        color: white;
    }

    .lesson-title {
        flex: 1;
        font-size: 0.9rem;
        color: #374151;
    }

    .lesson-date {
        font-size: 0.8rem;
        color: #9CA3AF;
    }

    .certificates-section {
        margin-top: 2rem;
    }

    .certificate-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #F9FAFB;
        border-radius: 8px;
        margin-bottom: 0.75rem;
        border-left: 4px solid #10B981;
    }

    .certificate-info {
        flex: 1;
    }

    .certificate-course {
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 0.25rem;
    }

    .certificate-date {
        font-size: 0.875rem;
        color: #6B7280;
    }

    .certificate-number {
        font-size: 0.875rem;
        color: #3B82F6;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 1rem;
        }

        .user-info {
            flex-direction: column;
            text-align: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .course-header {
            flex-direction: column;
        }

        .course-status {
            margin-top: 0.5rem;
        }
    }
</style>

<div class="admin-container">
    <!-- Header with user info -->
    <div class="progress-header">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <h2>{{ $user->name }}</h2>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Typ:</strong> {{ $user->user_type === 'farmaceuta' ? 'Farmaceuta' : 'Technik farmacji' }}</p>
                <p><strong>Rejestracja:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
                @if($user->pwz_number)
                    <p><strong>PWZ:</strong> {{ $user->pwz_number }}</p>
                @endif
            </div>
        </div>
        <div style="margin-top: 1.5rem;">
            <a href="{{ route('admin.users') }}" class="back-button">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Powrót do listy użytkowników
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number total">{{ $totalCourses }}</div>
            <div class="stat-label">Wszystkie kursy</div>
        </div>
        <div class="stat-card">
            <div class="stat-number completed">{{ $completedCourses }}</div>
            <div class="stat-label">Ukończone kursy</div>
        </div>
        <div class="stat-card">
            <div class="stat-number in-progress">{{ $inProgressCourses }}</div>
            <div class="stat-label">Kursy w toku</div>
        </div>
    </div>

    <!-- Courses Progress -->
    <div class="courses-container">
        <h3 class="section-title">Postępy w kursach</h3>

        @forelse($courses as $course)
            @php
                $courseProgress = $userProgress->get($course->id, collect());
                $completedLessons = $courseProgress->where('is_completed', true)->count();
                $totalLessons = $course->lessons->count();
                $progressPercentage = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
                $hasCertificate = $certificates->where('course_id', $course->id)->where('is_valid', true)->first();
                $status = $hasCertificate ? 'completed' : ($completedLessons > 0 ? 'in-progress' : 'not-started');
            @endphp

            <div class="course-card">
                <div class="course-header">
                    <div style="flex: 1;">
                        <div class="course-title">{{ $course->title }}</div>
                        <div style="color: #6B7280; font-size: 0.9rem; margin-bottom: 0.5rem;">
                            {{ $completedLessons }} / {{ $totalLessons }} lekcji ukończonych
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>
                    <div class="course-status status-{{ $status }}">
                        @if($status == 'completed')
                            ✅ Ukończony
                        @elseif($status == 'in-progress')
                            🔄 W toku
                        @else
                            ⏸️ Nie rozpoczęty
                        @endif
                    </div>
                </div>

                @if($completedLessons > 0 || $hasCertificate)
                    <div class="lessons-list">
                        @if($hasCertificate)
                            <div class="certificate-item">
                                <div class="certificate-info">
                                    <div class="certificate-course">🏆 Certyfikat wydany</div>
                                    <div class="certificate-date">
                                        Data wydania: {{ $hasCertificate->issued_at->format('d.m.Y H:i') }}
                                    </div>
                                </div>
                                <div class="certificate-number">
                                    #{{ $hasCertificate->certificate_number }}
                                </div>
                            </div>
                        @endif

                        @if($courseProgress->isNotEmpty())
                            <div style="font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">
                                Ukończone lekcje:
                            </div>
                            @foreach($courseProgress->where('is_completed', true)->sortBy('completed_at') as $progress)
                                <div class="lesson-item completed">
                                    <div class="lesson-icon">✓</div>
                                    <div class="lesson-title">{{ $progress->lesson->title ?? 'Lekcja ' . $progress->lesson_id }}</div>
                                    <div class="lesson-date">
                                        {{ $progress->completed_at->format('d.m.Y H:i') }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div style="text-align: center; padding: 3rem; color: #6B7280;">
                <svg style="width: 48px; height: 48px; margin: 0 auto 1rem; color: #D1D5DB;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem;">Brak dostępnych kursów</h3>
                <p>W systemie nie ma jeszcze żadnych kursów do wyświetlenia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection