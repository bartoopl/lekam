@extends('layouts.app')

@section('content')
<style>
    body {
        padding-top: 120px;
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }

    .user-header {
        margin-bottom: 2rem;
    }

    .user-name {
        font-size: 3.5rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 0.5rem;
    }

    .user-type {
        font-size: 1.2rem;
        color: #666;
        text-transform: capitalize;
        margin-bottom: 3rem;
    }

    .dashboard-content {
        display: grid;
        grid-template-columns: 1fr 450px;
        gap: 3rem;
        align-items: start;
    }

    .stats-section {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            0 4px 16px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .stats-section:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 12px 40px rgba(0, 0, 0, 0.15),
            0 6px 20px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .stat-box {
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 2rem 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .stat-number {
        font-size: 4rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 0.5rem;
        display: block;
        line-height: 1;
    }

    .stat-label {
        font-size: 1rem;
        color: #21235F;
        font-weight: 500;
        text-transform: lowercase;
        letter-spacing: 0.05em;
    }

    .admin-panel-box {
        background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        color: white;
        margin-top: 1rem;
    }

    .admin-panel-box:hover {
        background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%);
    }

    .admin-panel-box .stat-number {
        color: white;
    }

    .admin-panel-box .stat-label {
        color: rgba(255, 255, 255, 0.9);
    }

    .courses-section {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        height: fit-content;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            0 4px 16px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .courses-section:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 12px 40px rgba(0, 0, 0, 0.15),
            0 6px 20px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .courses-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .course-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        margin-bottom: 1rem;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        box-shadow: 
            0 4px 16px rgba(0, 0, 0, 0.08),
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .course-item:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px) translateX(3px);
        text-decoration: none;
        color: inherit;
        box-shadow: 
            0 8px 24px rgba(0, 0, 0, 0.12),
            0 4px 12px rgba(0, 0, 0, 0.06),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.25);
    }

    .course-thumbnail {
        width: 80px;
        height: 60px;
        margin-right: 1rem;
        flex-shrink: 0;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .course-thumbnail-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .course-icon {
        width: 80px;
        height: 60px;
        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .course-info {
        flex: 1;
    }

    .course-name {
        font-weight: 600;
        color: #21235F;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .course-progress {
        font-size: 0.85rem;
        color: #666;
    }

    .progress-bar {
        width: 100%;
        height: 6px;
        border-radius: 3px;
        margin-top: 0.5rem;
        overflow: hidden;
        position: relative;
        background: linear-gradient(to right, #21235F 0%, #3B82F6 50%, #22C55E 100%);
    }

    .progress-bar-gradient {
        display: none;
    }

    .progress-fill {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        background: rgba(255, 255, 255, 0.3);
        transition: width 0.3s ease;
    }

    .no-courses {
        text-align: center;
        color: #666;
        font-style: italic;
        padding: 2rem;
    }

    .overall-progress-section {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            0 4px 16px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .overall-progress-section:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 12px 40px rgba(0, 0, 0, 0.15),
            0 6px 20px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .overall-progress-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 1.5rem;
    }

    .circular-progress-container {
        position: relative;
        width: 140px;
        height: 140px;
        margin: 0 auto 1rem;
    }

    .circular-progress {
        transform: rotate(-90deg);
        width: 140px;
        height: 140px;
    }

    .progress-circle-bg {
        fill: none;
        stroke: rgba(33, 35, 95, 0.2);
        stroke-width: 12;
    }

    .progress-circle-fill {
        fill: none;
        stroke: url(#overallProgressGradient);
        stroke-width: 12;
        stroke-linecap: round;
        stroke-dasharray: 0 440;
        transition: stroke-dasharray 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        filter: drop-shadow(0 0 8px rgba(33, 35, 95, 0.3));
    }

    .progress-percentage-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2rem;
        font-weight: 700;
        color: #21235F;
    }

    .progress-subtitle {
        font-size: 0.9rem;
        color: #666;
        margin-top: 0.5rem;
    }

    @keyframes progressAnimation {
        from { stroke-dasharray: 0 440; }
        to { stroke-dasharray: var(--progress) 440; }
    }

    @media (max-width: 768px) {
        .dashboard-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .user-name {
            font-size: 2.5rem;
        }
        
        .stat-number {
            font-size: 3rem;
        }
        
        .dashboard-container {
            padding: 1rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-content">
        <!-- Left side - Statistics -->
        <div class="stats-section">
            <!-- User info header -->
            <div class="user-header">
                <h1 class="user-name">{{ $user->name }}</h1>
                <p class="user-type">{{ $user->user_type === 'farmaceuta' ? 'Farmaceuta' : 'Technik Farmacji' }}</p>
            </div>
            <div class="stats-grid">
                <!-- Completed Courses -->
                <div class="stat-box">
                    <span class="stat-number">{{ $completedCourses }}/{{ $totalAvailableCourses }}</span>
                    <div class="stat-label">Ukończone kursy</div>
                </div>

                <!-- Generated Certificates -->
                <div class="stat-box">
                    <span class="stat-number">{{ $certificatesCount }}</span>
                    <div class="stat-label">Wygenerowane certyfikaty</div>
                </div>

                <!-- Total Points -->
                <div class="stat-box">
                    <span class="stat-number">{{ $totalPoints }}</span>
                    <div class="stat-label">Zdobyte punkty</div>
                </div>
            </div>

            @if($user->isAdmin() || $user->email === 'admin@admin.com' || $user->user_type === 'admin')
                <!-- Admin Panel Access -->
                <a href="{{ route('admin.dashboard') }}" class="stat-box admin-panel-box" style="text-decoration: none; color: inherit;">
                    <span class="stat-number">⚙️</span>
                    <div class="stat-label">Panel Administratora</div>
                </a>
            @endif
            
            <!-- Certificates Section -->
            @php
                $certificates = $user->certificates()->with('course')->orderBy('issued_at', 'desc')->get();
            @endphp
            @if($certificates->count() > 0)
                <div style="margin-top: 2rem;">
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #21235F; margin-bottom: 1rem; text-align: center;">Moje certyfikaty</h3>
                    <div style="space-y: 1rem;">
                        @foreach($certificates as $certificate)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 12px; margin-bottom: 1rem; transition: all 0.3s ease;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                                        📜
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #21235F; font-size: 0.9rem;">{{ $certificate->course->title }}</div>
                                        <div style="font-size: 0.75rem; color: #666;">{{ $certificate->issued_at->format('d.m.Y') }}</div>
                                    </div>
                                </div>
                                <a href="{{ route('certificates.download', $certificate) }}" 
                                   style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%); color: white; padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-size: 0.8rem; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem;">
                                    ⬇️ Pobierz
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right side - Overall Progress and My Courses -->
        <div>
            <!-- Overall Progress Section -->
            @php
                $overallProgressPercentage = $totalAvailableCourses > 0 ? round(($completedCourses / $totalAvailableCourses) * 100) : 0;
            @endphp
            <div class="overall-progress-section">
                <h3 class="overall-progress-title">Ogólny postęp</h3>
                <div class="circular-progress-container">
                    <svg class="circular-progress" viewBox="0 0 140 140">
                        <defs>
                            <linearGradient id="overallProgressGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#21235F" />
                                <stop offset="50%" stop-color="#3B82F6" />
                                <stop offset="100%" stop-color="#22C55E" />
                            </linearGradient>
                        </defs>
                        <!-- Background circle -->
                        <circle class="progress-circle-bg" cx="70" cy="70" r="60" />
                        <!-- Progress circle -->
                        <circle class="progress-circle-fill" cx="70" cy="70" r="60" id="overallProgressCircle" />
                    </svg>
                    <div class="progress-percentage-text">{{ $overallProgressPercentage }}%</div>
                </div>
                <div class="progress-subtitle">{{ $completedCourses }} z {{ $totalAvailableCourses }} kursów ukończonych</div>
            </div>

            <!-- My Courses Section -->
            <div class="courses-section">
                <h2 class="courses-title">Moje kursy</h2>
            
            @if($enrolledCourses->count() > 0)
                @foreach($enrolledCourses as $course)
                    @php
                        $totalLessons = $course->lessons()->count();
                        $completedLessons = $course->lessons()
                            ->whereHas('userProgress', function($query) use ($user) {
                                $query->where('user_id', $user->id)->where('is_completed', true);
                            })->count();
                        $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                    @endphp
                    
                    <a href="{{ route('courses.show', $course->id) }}" class="course-item">
                        <div class="course-thumbnail">
                            @if($course->image)
                                <img src="{{ str_starts_with($course->image, 'http') ? $course->image : Storage::url($course->image) }}" alt="{{ $course->title }}" class="course-thumbnail-img">
                            @else
                                <div class="course-icon">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="course-info">
                            <div class="course-name">{{ $course->title }}</div>
                            <div class="course-progress">{{ $progressPercentage }}% ukończone</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ 100 - $progressPercentage }}%"></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="no-courses">
                    <p>Nie jesteś zapisany na żaden kurs.</p>
                    <a href="{{ route('courses') }}" style="color: #3B82F6; text-decoration: none; font-weight: 600;">
                        Przeglądaj dostępne kursy →
                    </a>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>

<script>
// Animate overall progress circle on page load
document.addEventListener('DOMContentLoaded', function() {
    const progressCircle = document.getElementById('overallProgressCircle');
    const percentage = {{ $overallProgressPercentage }};
    
    if (progressCircle && percentage > 0) {
        // Calculate circumference of the circle (2 * π * r, where r = 60)
        const circumference = 2 * Math.PI * 60; // ≈ 377
        const progress = (percentage / 100) * circumference;
        
        // Set initial state
        progressCircle.style.strokeDasharray = `0 ${circumference}`;
        
        // Animate to final state after a short delay
        setTimeout(() => {
            progressCircle.style.strokeDasharray = `${progress} ${circumference}`;
        }, 500);
    }
});
</script>
@endsection