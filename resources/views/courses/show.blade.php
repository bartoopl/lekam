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

    .course-header {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .course-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 1.5rem;
        font-family: 'Poppins', sans-serif;
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

    .progress-section {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1rem;
        margin-bottom: 2rem;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .progress-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #21235F;
    }

    .progress-percentage {
        font-size: 1.2rem;
        font-weight: 700;
        color: #3B82F6;
    }

    .progress-bar-container {
        position: relative;
        height: 120px;
        width: 100%;
        overflow: visible;
        margin: 20px 0;
    }

    .sinusoidal-progress {
        width: 100%;
        height: 120px;
        overflow: visible;
    }

    .progress-path-bg {
        fill: none;
        stroke: rgba(33, 35, 95, 0.3);
        stroke-width: 6;
        stroke-linecap: round;
    }

    .progress-path {
        fill: none;
        stroke-width: 6;
        stroke-linecap: round;
        transition: stroke-dasharray 1s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .progress-dot {
        r: 8;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        transition: cx 1s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .progress-pulse {
        r: 8;
        opacity: 0.4;
        animation: progressPulse 2s ease-in-out infinite;
    }

    @keyframes progressPulse {
        0%, 100% {
            transform: scale(1);
            opacity: 0.4;
        }
        50% {
            transform: scale(1.5);
            opacity: 0.1;
        }
    }

    .quiz-section {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .quiz-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .quiz-info {
        flex: 1;
    }

    .quiz-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .quiz-description {
        color: #666;
        line-height: 1.5;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .quiz-details {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .quiz-detail {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #666;
        background: rgba(255, 255, 255, 0.8);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.6);
    }

    .quiz-detail svg {
        color: #3B82F6;
    }

    .quiz-actions {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        min-width: 200px;
    }

    .quiz-button {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        text-align: center;
        min-width: 160px;
    }

    .quiz-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .quiz-passed {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: #10B981;
        background: rgba(16, 185, 129, 0.1);
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid rgba(16, 185, 129, 0.3);
        text-align: center;
        min-width: 160px;
    }

    .quiz-passed svg {
        width: 2rem;
        height: 2rem;
        color: #10B981;
    }

    .quiz-failed {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: #EF4444;
        background: rgba(239, 68, 68, 0.1);
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid rgba(239, 68, 68, 0.3);
        text-align: center;
        min-width: 160px;
    }

    .quiz-failed svg {
        width: 2rem;
        height: 2rem;
        color: #EF4444;
    }

    .quiz-locked {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: #6B7280;
        background: rgba(107, 114, 128, 0.1);
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid rgba(107, 114, 128, 0.3);
        text-align: center;
        min-width: 160px;
    }

    .quiz-locked svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #6B7280;
    }

    .quiz-score {
        font-size: 1.2rem;
        font-weight: 700;
        margin-top: 0.25rem;
    }

    .course-content {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 2rem;
        min-height: 600px;
    }

    .chapters-sidebar {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        height: fit-content;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .chapters-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .chapter-item {
        margin-bottom: 1rem;
        border-radius: 10px;
        overflow: hidden;
    }

    .chapter-header {
        background: rgba(255, 255, 255, 0.9);
        padding: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .chapter-header:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .chapter-title {
        font-weight: 600;
        color: #21235F;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .chapter-description {
        font-size: 0.85rem;
        color: #666;
        line-height: 1.4;
    }

    .lessons-list {
        padding: 0 1rem;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .lessons-list.expanded {
        max-height: 2000px;
        padding: 1rem;
    }

    .lesson-item {
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    .lesson-item:hover {
        background: rgba(255, 255, 255, 0.7);
        border-color: rgba(59, 130, 246, 0.5);
        transform: translateX(5px);
    }

    .lesson-item.active {
        background: rgba(59, 130, 246, 0.2);
        border-color: #3B82F6;
        box-shadow: 0 2px 10px rgba(59, 130, 246, 0.2);
    }

    .lesson-item.completed {
        background: rgba(34, 197, 94, 0.1);
        border-left: 4px solid #22c55e;
    }

    .lesson-item.locked {
        background: rgba(156, 163, 175, 0.1);
        border-left: 4px solid #9ca3af;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .lesson-item.locked:hover {
        background: rgba(156, 163, 175, 0.1);
        transform: none;
    }

    .lesson-title {
        font-size: 1rem;
        color: #21235F;
        font-weight: 500;
    }

    .lesson-status {
        font-size: 0.75rem;
        color: #666;
        margin-top: 0.25rem;
    }

    .lesson-content {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        min-height: 600px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .lesson-header {
        margin-bottom: 2rem;
    }

    .lesson-title-main {
        font-size: 1.3rem;
        font-weight: 700;
        color: #21235F;
        margin-bottom: 1rem;
    }

    .lesson-description {
        color: #666;
        line-height: 1.6;
        font-size: 1rem;
    }

    .lesson-video {
        margin-bottom: 2rem;
    }

    .video-container {
        position: relative;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .lesson-materials {
        margin-bottom: 2rem;
    }

    .materials-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #21235F;
        margin-bottom: 1rem;
    }

    .material-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: 10px;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .material-item:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .material-icon {
        width: 40px;
        height: 40px;
        background: #3B82F6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
    }

    .material-info {
        flex: 1;
    }

    .material-name {
        font-weight: 600;
        color: #21235F;
        margin-bottom: 0.25rem;
    }

    .material-size {
        font-size: 0.85rem;
        color: #666;
    }

    .material-download {
        padding: 0.5rem 1rem;
        background: #3B82F6;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .material-download:hover {
        background: #2563EB;
        transform: translateY(-1px);
    }

    .instructor-info {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        margin-top: 2rem;
    }

    .instructor-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
        border: 3px solid rgba(59, 130, 246, 0.3);
    }

    .instructor-details {
        flex: 1;
    }

    .instructor-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #21235F;
        margin-bottom: 0.25rem;
    }

    .instructor-title {
        color: #666;
        font-size: 0.9rem;
    }

    .no-lesson-selected {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 400px;
        color: #666;
        font-size: 1.1rem;
        text-align: center;
    }

    .auto-start-lesson {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 400px;
        color: #666;
        font-size: 1.1rem;
        text-align: center;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .course-content {
            grid-template-columns: 1fr;
        }
        
        .course-title {
            font-size: 2rem;
        }

        .quiz-header {
            flex-direction: column;
            gap: 1rem;
        }

        .quiz-actions {
            min-width: 100%;
        }

        .quiz-details {
            gap: 0.5rem;
        }

        .quiz-detail {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }
    }
</style>

<div class="container mx-auto px-4 py-4">
    <!-- Course Header -->
    <div class="course-header">
        <div class="breadcrumbs">
            <a href="{{ route('home') }}" class="breadcrumb-item">Strona główna</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('courses') }}" class="breadcrumb-item">Szkolenia</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-item">{{ $course->title }}</span>
        </div>
        
        <h1 class="course-title">{{ $course->title }}</h1>
    </div>

    <!-- Progress Section -->
    <div class="progress-section">
        <div class="progress-header">
            <div class="progress-title">Postęp kursu</div>
            <div class="progress-percentage">{{ $progressPercentage }}%</div>
        </div>
        <div class="progress-bar-container">
            <svg class="sinusoidal-progress" viewBox="0 0 800 120" preserveAspectRatio="none">
                <!-- Gradient definitions -->
                <defs>
                    <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#21235F" />
                        <stop offset="100%" stop-color="#22C55E" />
                    </linearGradient>
                    <radialGradient id="dotGradient" cx="50%" cy="30%">
                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.8"/>
                        <stop offset="100%" stop-color="#21235F" stop-opacity="1"/>
                    </radialGradient>
                </defs>
                
                <!-- Background path -->
                <path id="progress-path-bg" class="progress-path-bg" 
                      d="M 0 60 
                         C 50 20, 100 20, 150 60
                         C 180 80, 180 100, 150 100
                         C 120 100, 120 80, 150 60
                         C 200 40, 250 40, 300 60
                         C 330 20, 370 20, 400 60
                         C 420 100, 420 40, 400 60
                         C 450 80, 500 80, 550 60
                         C 580 20, 620 100, 650 60
                         C 700 40, 750 80, 800 60" />
                
                <!-- Progress path -->
                <path id="progress-path" class="progress-path" 
                      stroke="url(#progressGradient)"
                      d="M 0 60 
                         C 50 20, 100 20, 150 60
                         C 180 80, 180 100, 150 100
                         C 120 100, 120 80, 150 60
                         C 200 40, 250 40, 300 60
                         C 330 20, 370 20, 400 60
                         C 420 100, 420 40, 400 60
                         C 450 80, 500 80, 550 60
                         C 580 20, 620 100, 650 60
                         C 700 40, 750 80, 800 60" />
                
                <!-- Animated pulse -->
                <circle class="progress-pulse" cx="0" cy="60" fill="url(#progressGradient)" />
                
                <!-- Progress dot -->
                <circle class="progress-dot" cx="0" cy="60" fill="url(#dotGradient)" stroke="#ffffff" stroke-width="2" />
            </svg>
        </div>
        <div class="mt-4 text-sm text-gray-600">
            {{ $completedLessons }} z {{ $totalLessons }} lekcji ukończonych
        </div>
        
        <!-- Test Reset Button -->
        <div class="mt-4 p-3 bg-yellow-100 border border-yellow-300 rounded-md">
            <div class="flex items-center justify-between">
                <div class="text-yellow-800 text-sm">
                    <strong>🧪 Funkcja testowa:</strong> Przycisk do resetowania postępu
                </div>
                <button onclick="resetCourseProgress()" 
                        class="btn btn-danger">
                    Resetuj postęp kursu
                </button>
            </div>
        </div>
    </div>


    <!-- Course Content -->
    <div class="course-content">
        <!-- Chapters Sidebar -->
        <div class="chapters-sidebar">
            <h3 class="chapters-title">
                @if($chapters->isNotEmpty())
                    Spis tematów
                @else
                    Lista lekcji
                @endif
            </h3>
            
            @if($chapters->isNotEmpty())
                @foreach($chapters as $chapter)
                    <div class="chapter-item">
                        <div class="chapter-header" onclick="toggleChapter({{ $chapter->id }})">
                            <div class="chapter-title">{{ $chapter->title }}</div>
                            @if($chapter->description)
                                <div class="chapter-description">{{ $chapter->description }}</div>
                            @endif
                        </div>
                        <div class="lessons-list expanded" id="lessons-{{ $chapter->id }}">
                            @foreach($chapter->lessons as $lesson)
                                @php
                                    $isCompleted = $lesson->userProgress->first()?->is_completed ?? false;
                                    $isActive = request()->has('lesson') && request()->get('lesson') == $lesson->id;
                                    $isAccessible = auth()->check() ? $lesson->isAccessibleByUser(auth()->user()) : true;
                                @endphp
                                <div class="lesson-item {{ $isActive ? 'active' : '' }} {{ $isCompleted ? 'completed' : '' }} {{ !$isAccessible ? 'locked' : '' }}" 
                                     data-lesson-id="{{ $lesson->id }}"
                                     @if($isAccessible) onclick="loadLesson({{ $lesson->id }}, '{{ $lesson->title }}')" @endif>
                                    <div class="lesson-title">{{ $lesson->title }}</div>
                                    <div class="lesson-status">
                                        @if($isCompleted)
                                            ✓ Ukończona
                                        @elseif(!$isAccessible)
                                            🔒 Zablokowana
                                        @else
                                            ○ Nieukończona
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                <!-- Final Test Section -->
                @if($quiz && $quiz->is_active)
                    <div class="chapter-item">
                        <div class="chapter-header">
                            <div class="chapter-title">Test końcowy</div>
                            <div class="chapter-description">Sprawdź swoją wiedzę po ukończeniu wszystkich lekcji</div>
                        </div>
                        <div class="lessons-list expanded">
                            <div class="lesson-item {{ ($quizAttempt && $quizAttempt->passed) ? 'completed' : '' }}" 
                                 onclick="navigateToQuiz()">
                                <div class="lesson-title">{{ $quiz->title }}</div>
                                <div class="lesson-status">
                                    @if($quizAttempt && $quizAttempt->passed)
                                        ✓ Zaliczony ({{ $quizAttempt->percentage }}%)
                                    @elseif($quizAttempt && !$quizAttempt->passed)
                                        ✗ Niezaliczony ({{ $quizAttempt->percentage }}%)
                                    @elseif($canTakeQuiz)
                                        ○ Dostępny
                                    @else
                                        🔒 Zablokowany
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Display lessons directly when no chapters exist -->
                @foreach($lessons as $lesson)
                    @php
                        $isCompleted = $lesson->userProgress->first()?->is_completed ?? false;
                        $isActive = request()->has('lesson') && request()->get('lesson') == $lesson->id;
                        $isAccessible = auth()->check() ? $lesson->isAccessibleByUser(auth()->user()) : true;
                    @endphp
                    <div class="lesson-item {{ $isActive ? 'active' : '' }} {{ $isCompleted ? 'completed' : '' }} {{ !$isAccessible ? 'locked' : '' }}" 
                         data-lesson-id="{{ $lesson->id }}"
                         @if($isAccessible) onclick="loadLesson({{ $lesson->id }}, '{{ $lesson->title }}')" @endif>
                        <div class="lesson-title">{{ $lesson->title }}</div>
                        <div class="lesson-status">
                            @if($isCompleted)
                                ✓ Ukończona
                            @elseif(!$isAccessible)
                                🔒 Zablokowana
                            @else
                                ○ Nieukończona
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Lesson Content -->
        <div class="lesson-content" id="lesson-content">
            @if($firstAvailableLesson)
                <div class="auto-start-lesson">
                    <div class="text-center">
                        <h3>Rozpoczynanie nauki...</h3>
                        <p>Automatycznie ładuję pierwszą dostępną lekcję: <strong>{{ $firstAvailableLesson->title }}</strong></p>
                        <div class="mt-4">
                            <button onclick="loadLesson({{ $firstAvailableLesson->id }}, '{{ $firstAvailableLesson->title }}')" 
                                    class="btn btn-primary">
                                Rozpocznij naukę
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="no-lesson-selected">
                    <div class="text-center">
                        @if(auth()->check() && !auth()->user()->hasStartedCourse($course))
                            <h3>Dołącz do szkolenia</h3>
                            <p>Rozpocznij naukę klikając przycisk poniżej</p>
                            <div class="mt-6">
                                <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" 
                                        style="background-color: #21235F; color: white; padding: 0.75rem 1.5rem; border-radius: 16px; border: 2px solid #21235F; font-weight: 500; cursor: pointer; transition: all 0.2s ease;">
                                        Dołącz do szkolenia
                                    </button>
                                </form>
                            </div>
                        @else
                            <h3>Wybierz lekcję z listy po lewej stronie</h3>
                            <p>Aby rozpocząć naukę, kliknij na jedną z lekcji w spisie tematów.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Auto-start first available lesson
@if($firstAvailableLesson)
document.addEventListener('DOMContentLoaded', function() {
    // Auto-load first available lesson after a short delay
    setTimeout(() => {
        loadLesson({{ $firstAvailableLesson->id }}, '{{ $firstAvailableLesson->title }}');
    }, 1000);
});
@endif

function toggleChapter(chapterId) {
    const lessonsList = document.getElementById(`lessons-${chapterId}`);
    lessonsList.classList.toggle('expanded');
}

function loadLesson(lessonId, lessonTitle) {
    // Update active state
    document.querySelectorAll('.lesson-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Find and activate the clicked lesson
    const lessonItems = document.querySelectorAll('.lesson-item');
    lessonItems.forEach(item => {
        if (item.onclick && item.onclick.toString().includes(lessonId)) {
            item.classList.add('active');
        }
    });
    
    // Load lesson content via AJAX
    fetch(`/courses/{{ $course->id }}/lesson/${lessonId}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('lesson-content').innerHTML = html;
            
            // Initialize video controls after content is loaded
            setTimeout(() => {
                initializeVideoControls();
                // Initialize countdown timer if it exists
                initializeCountdownTimer();
                // Setup material download handlers
                setupMaterialDownloadHandlers(lessonId);
                // Give more time for navigation buttons to be rendered in lesson content
                setTimeout(() => {
                    updateNavigationButtons();
                }, 200);
            }, 100);
        })
        .catch(error => {
            console.error('Error loading lesson:', error);
        });
}

function initializeVideoControls() {
    console.log('initializeVideoControls called');
    const video = document.getElementById('lesson-video');
    console.log('Video element found:', !!video);
    
    if (video && !video.hasAttribute('data-initialized')) {
        video.setAttribute('data-initialized', 'true');
        console.log('Video initialized');
        
        // Add basic controls first
        video.controls = true;
        console.log('Basic controls added');
        
        // Try to call custom controls
        if (typeof window.initVideoJSPlayer === 'function') {
            console.log('Video.js player function found, calling...');
            try {
                const options = {
                    saveUrl: video.dataset.savePositionUrl,
                    startPosition: video.dataset.startPosition,
                    completeUrl: video.dataset.completeLessonUrl
                };
                window.initVideoJSPlayer(video, options);
                console.log('Video.js player initialized successfully');
            } catch (error) {
                console.error('Error initializing Video.js player:', error);
            }
        } else {
            console.log('Custom controls function not found, using fallback');
        }
        
        // Auto-complete lesson when video ends
        video.addEventListener('ended', function() {
            const completeUrl = video.dataset.completeLessonUrl;
            if (completeUrl) {
                fetch(completeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        // Update UI to show lesson as completed
                        const lessonItem = document.querySelector('.lesson-item.active');
                        if (lessonItem) {
                            lessonItem.classList.add('completed');
                            const statusElement = lessonItem.querySelector('.lesson-status');
                            if (statusElement) {
                                statusElement.textContent = '✓ Ukończona';
                            }
                        }
                        
                        // Show success message
                        showSuccessMessage('Lekcja została oznaczona jako ukończona!');
                        
                        // Refresh lesson accessibility after a short delay
                        console.log('Video ended, will refresh lessons accessibility in 1 second');
                        setTimeout(() => {
                            console.log('Calling refreshLessonsAccessibility from video end handler');
                            refreshLessonsAccessibility();
                        }, 1000);
                    }
                }).catch(error => {
                    console.error('Error completing lesson:', error);
                });
            }
        });
    }
}

function showSuccessMessage(message) {
    // Create and show success notification
    const notification = document.createElement('div');
    notification.className = 'fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Global variable to track quiz availability
let canTakeQuiz = {{ $canTakeQuiz ? 'true' : 'false' }};

function navigateToQuiz() {
    if(canTakeQuiz) {
        // Update active state
        document.querySelectorAll('.lesson-item').forEach(item => {
            item.classList.remove('active');
        });
        event.target.closest('.lesson-item').classList.add('active');
        
        // Load quiz content via AJAX
        fetch(`/courses/{{ $course->id }}/quiz/content`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('lesson-content').innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading quiz:', error);
                // Fallback to regular navigation
                window.location.href = '{{ route("quizzes.show", $course) }}';
            });
    } else {
        alert('Test jest niedostępny. Ukończ wszystkie lekcje aby przystąpić do testu.');
    }
}

// Function to update quiz status when course is completed
function updateQuizStatus() {
    canTakeQuiz = true;
    
    // Update quiz lesson item status
    const quizItem = document.querySelector('.lesson-item[onclick="navigateToQuiz()"]');
    if (quizItem) {
        const statusElement = quizItem.querySelector('.lesson-status');
        if (statusElement && statusElement.textContent.includes('🔒 Zablokowany')) {
            statusElement.textContent = '○ Dostępny';
        }
    }
}

// Global function to start quiz
function startQuiz() {
    console.log('startQuiz called');
    
    if (confirm('Czy na pewno chcesz rozpocząć test? Po rozpoczęciu nie będziesz mógł go przerwać.')) {
        const startBtn = document.getElementById('startQuizBtn');
        
        // Show loading state
        if (startBtn) {
            startBtn.disabled = true;
            startBtn.textContent = 'Rozpoczynanie...';
        }
        
        // First, start the quiz attempt
        fetch('{{ route("quizzes.start", $course) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Quiz started, response data:', data);
            if (data.success) {
                // Now load the quiz questions via AJAX
                const attemptId = data.attempt_id;
                const questionsUrl = `/courses/{{ $course->id }}/quiz/questions/${attemptId}`;
                
                console.log('Loading questions from:', questionsUrl);
                
                return fetch(questionsUrl);
            } else {
                throw new Error(data.message || data.error || 'Quiz start failed');
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            console.log('Questions loaded successfully');
            // Replace the lesson content with quiz questions
            document.getElementById('lesson-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error starting quiz:', error);
            alert('Wystąpił błąd podczas rozpoczynania testu: ' + error.message);
            if (startBtn) {
                startBtn.disabled = false;
                startBtn.textContent = 'Rozpocznij test';
            }
        });
    }
}

function refreshLessonsAccessibility() {
    console.log('refreshLessonsAccessibility called');
    // Fetch updated lesson accessibility from server
    fetch(`/courses/{{ $course->id }}/lessons-status`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Received data:', data);
        if (data.success && data.lessons) {
            // Update each lesson's accessibility in the UI
            data.lessons.forEach(lesson => {
                console.log(`Processing lesson ${lesson.id}: completed=${lesson.is_completed}, accessible=${lesson.is_accessible}`);
                
                // Find lesson element by data-lesson-id
                const element = document.querySelector(`[data-lesson-id="${lesson.id}"]`);
                
                if (element) {
                    console.log(`Found lesson element for lesson ${lesson.id} by data-lesson-id`);
                    const statusElement = element.querySelector('.lesson-status');
                    
                    // Update lesson classes and status
                    element.classList.remove('locked', 'completed');
                    
                    if (lesson.is_completed) {
                        console.log(`Marking lesson ${lesson.id} as completed`);
                        element.classList.add('completed');
                        if (statusElement) {
                            statusElement.textContent = '✓ Ukończona';
                        }
                    } else if (!lesson.is_accessible) {
                        console.log(`Marking lesson ${lesson.id} as locked`);
                        element.classList.add('locked');
                        if (statusElement) {
                            statusElement.textContent = '🔒 Zablokowana';
                        }
                        // Remove onclick if locked
                        element.removeAttribute('onclick');
                        element.style.cursor = 'not-allowed';
                    } else {
                        console.log(`Marking lesson ${lesson.id} as accessible`);
                        if (statusElement) {
                            statusElement.textContent = '○ Nieukończona';
                        }
                        // Ensure onclick is present if accessible
                        element.setAttribute('onclick', `loadLesson(${lesson.id}, '${lesson.title.replace(/'/g, "\\\'")}')`);
                        element.style.cursor = 'pointer';
                    }
                } else {
                    console.warn(`Could not find lesson element for lesson ${lesson.id} (${lesson.title})`);
                }
            });
            
            // Update progress bar if provided
            if (data.progress_percentage !== undefined) {
                updateSinusoidalProgress(data.progress_percentage);
                
                const progressPercentage = document.querySelector('.progress-percentage');
                const progressText = document.querySelector('.progress-section .text-sm');
                
                if (progressPercentage) {
                    progressPercentage.textContent = data.progress_percentage + '%';
                }
                if (progressText && data.completed_lessons !== undefined && data.total_lessons !== undefined) {
                    progressText.textContent = `${data.completed_lessons} z ${data.total_lessons} lekcji ukończonych`;
                }
            }
            
            // After updating all lessons, update navigation buttons
            console.log('Lessons updated, now updating navigation buttons');
            updateNavigationButtons();
        }
    })
    .catch(error => {
        console.error('Error refreshing lessons accessibility:', error);
    });
}

function updateNavigationButtons() {
    console.log('updateNavigationButtons called');
    
    // Try to find buttons in the lesson content (loaded via AJAX)
    const prevBtn = document.getElementById('lesson-prev-btn');
    const nextBtn = document.getElementById('lesson-next-btn');
    
    if (!prevBtn || !nextBtn) {
        console.log('Navigation buttons not found in lesson content yet');
        return;
    }
    
    // Find current active lesson
    const activeLesson = document.querySelector('.lesson-item.active');
    if (!activeLesson) {
        console.log('No active lesson found');
        return;
    }
    
    console.log('Active lesson found, updating buttons');
    
    // Find previous lesson
    const prevLesson = findPreviousAccessibleLesson(activeLesson);
    if (prevLesson) {
        const prevOnClick = prevLesson.getAttribute('onclick');
        if (prevOnClick) {
            const prevIdMatch = prevOnClick.match(/loadLesson\((\d+),/);
            const prevTitleMatch = prevOnClick.match(/loadLesson\(\d+,\s*['"]([^'"]+)['"]/);
            
            if (prevIdMatch && prevTitleMatch) {
                prevBtn.disabled = false;
                prevBtn.className = 'btn btn-secondary flex items-center justify-center';
                prevBtn.style.cssText = 'min-width: 150px; height: 50px;';
                prevBtn.innerHTML = '← Poprzednia';
                prevBtn.onclick = () => loadLesson(parseInt(prevIdMatch[1]), prevTitleMatch[1]);
                console.log('Previous lesson enabled:', prevTitleMatch[1]);
            }
        }
    } else {
        prevBtn.disabled = true;
        prevBtn.className = 'btn btn-secondary flex items-center justify-center opacity-50 cursor-not-allowed';
        prevBtn.style.cssText = 'min-width: 150px; height: 50px;';
        prevBtn.innerHTML = '← Poprzednia';
        prevBtn.onclick = null;
        console.log('Previous lesson disabled');
    }
    
    // Find next lesson
    const nextLesson = findNextAccessibleLesson(activeLesson);
    if (nextLesson) {
        const nextOnClick = nextLesson.getAttribute('onclick');
        if (nextOnClick) {
            const nextIdMatch = nextOnClick.match(/loadLesson\((\d+),/);
            const nextTitleMatch = nextOnClick.match(/loadLesson\(\d+,\s*['"]([^'"]+)['"]/);
            
            if (nextIdMatch && nextTitleMatch) {
                nextBtn.disabled = false;
                nextBtn.className = 'btn btn-primary flex items-center justify-center';
                nextBtn.style.cssText = 'min-width: 150px; height: 50px;';
                
                // Check if current lesson has materials (suggests next is test)
                const hasDownloadMaterials = document.querySelector('.material-download') || 
                                           document.querySelector('[data-download-timer]') ||
                                           document.querySelector('#timer-display') ||
                                           document.querySelector('#countdown-timer');
                
                // Check if next lesson is test/quiz
                const isTestLesson = nextTitleMatch[1] && (nextTitleMatch[1].toLowerCase().includes('test') || nextTitleMatch[1].toLowerCase().includes('quiz'));
                
                // If current lesson has materials OR next is test, show test button
                if (hasDownloadMaterials || isTestLesson) {
                    nextBtn.innerHTML = 'Przejdź do testu końcowego →';
                } else {
                    nextBtn.innerHTML = 'Następna →';
                }
                
                nextBtn.onclick = () => loadLesson(parseInt(nextIdMatch[1]), nextTitleMatch[1]);
                console.log('Next lesson enabled:', nextTitleMatch[1], '| Has materials:', !!hasDownloadMaterials, '| Is test:', isTestLesson);
            }
        }
    } else {
        nextBtn.disabled = true;
        nextBtn.className = 'btn btn-primary flex items-center justify-center opacity-50 cursor-not-allowed';
        nextBtn.style.cssText = 'min-width: 150px; height: 50px;';
        nextBtn.innerHTML = 'Następna →';
        nextBtn.onclick = null;
        console.log('Next lesson disabled');
    }
}

function findPreviousAccessibleLesson(currentLesson) {
    const allLessons = Array.from(document.querySelectorAll('.lesson-item'));
    const currentIndex = allLessons.indexOf(currentLesson);
    
    for (let i = currentIndex - 1; i >= 0; i--) {
        const lesson = allLessons[i];
        if (!lesson.classList.contains('locked') && lesson.getAttribute('onclick')) {
            return lesson;
        }
    }
    return null;
}

function findNextAccessibleLesson(currentLesson) {
    const allLessons = Array.from(document.querySelectorAll('.lesson-item'));
    const currentIndex = allLessons.indexOf(currentLesson);
    
    for (let i = currentIndex + 1; i < allLessons.length; i++) {
        const lesson = allLessons[i];
        if (!lesson.classList.contains('locked') && lesson.getAttribute('onclick')) {
            return lesson;
        }
    }
    return null;
}

function resetCourseProgress() {
    if (confirm('Czy na pewno chcesz usunąć wszystkie postępy w tym kursie? Ta operacja jest nieodwracalna.')) {
        fetch(`/courses/{{ $course->id }}/reset-progress`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Postępy w kursie zostały usunięte.');
                // Reload the page to reflect the changes
                window.location.reload();
            } else {
                alert('Wystąpił błąd podczas resetowania postępów: ' + (data.message || data.error));
            }
        })
        .catch(error => {
            console.error('Error resetting progress:', error);
            alert('Wystąpił błąd podczas resetowania postępów: ' + error.message);
        });
    }
}

// Setup material download handlers
function setupMaterialDownloadHandlers(lessonId) {
    console.log('setupMaterialDownloadHandlers called for lesson:', lessonId);
    
    const downloadButtons = document.querySelectorAll('.material-download');
    console.log('Found download buttons:', downloadButtons.length);
    
    downloadButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            console.log('Material download clicked');
            event.preventDefault();
            
            const link = event.target.closest('.material-download');
            const timerMinutes = parseInt(link.dataset.downloadTimer) || 0;
            const completeUrl = link.dataset.completeLessonUrl;
            
            console.log('Timer minutes:', timerMinutes);
            console.log('Complete URL:', completeUrl);
            
            // First, update download tracking on backend
            const downloadUrl = '{{ route("courses.download-file", ["course" => $course, "lesson" => "__LESSON_ID__"]) }}'.replace('__LESSON_ID__', lessonId);
            console.log('Download tracking URL:', downloadUrl);
            
            fetch(downloadUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    action: 'mark_downloaded'
                })
            }).then(response => {
                console.log('Download marked as completed, response status:', response.status);
                
                // Now trigger actual download
                window.location.href = link.href;
                
                // Reload lesson content to show updated status and timer
                setTimeout(() => {
                    console.log('Reloading lesson content to show timer...');
                    loadLesson(lessonId, 'Reload for timer');
                }, 1500);
            }).catch(error => {
                console.error('Error marking download:', error);
                // Even if marking fails, allow download
                window.location.href = link.href;
            });
        });
    });
}

// Initialize countdown timer for download materials
function initializeCountdownTimer() {
    console.log('initializeCountdownTimer called');
    const countdownTimer = document.getElementById('countdown-timer');
    const timerDisplay = document.getElementById('timer-display');
    const quizSection = document.getElementById('quiz-start-section');
    
    // Check for either countdown-timer or timer-display
    const activeTimer = countdownTimer || timerDisplay;
    
    if (!activeTimer) {
        console.log('No countdown timer found');
        return;
    }
    
    console.log('Timer found:', activeTimer.id);
    
    // If it's timer-display, it already has JavaScript in lesson-content.blade.php
    if (activeTimer.id === 'timer-display') {
        console.log('timer-display found - JavaScript already handled in lesson-content');
        return;
    }
    
    // If countdown-timer shows --:--, it means PHP didn't initialize it properly
    if (activeTimer.id === 'countdown-timer' && activeTimer.textContent === '--:--') {
        console.log('countdown-timer shows --:--, trying to find lesson timer data...');
        
        // Look for download buttons to get timer duration
        const downloadButtons = document.querySelectorAll('.material-download');
        if (downloadButtons.length > 0) {
            const timerMinutes = parseInt(downloadButtons[0].dataset.downloadTimer) || 2;
            console.log('Found download timer:', timerMinutes, 'minutes');
            
            // Start countdown from the download timer value
            startCountdownFromMinutes(timerMinutes, downloadButtons[0].dataset.completeLessonUrl);
            return;
        }
    }
    
    console.log('Countdown timer found');
    console.log('Timer element content:', countdownTimer.textContent);
    console.log('Timer element HTML:', countdownTimer.outerHTML);
    
    // Extract the end time from the parent element's data or search for it in the HTML
    const timerParent = countdownTimer.closest('div');
    if (!timerParent) {
        console.log('No timer parent found');
        return;
    }
    console.log('Timer parent HTML:', timerParent.outerHTML);
    
    // Look for the script data that might contain the timer information
    const scriptTags = document.querySelectorAll('script');
    let canProceedAfter = null;
    
    // Try to find can_proceed_after data in the loaded content scripts
    scriptTags.forEach(script => {
        const scriptContent = script.textContent;
        if (scriptContent && scriptContent.includes('can_proceed_after')) {
            const dateMatch = scriptContent.match(/can_proceed_after.*?new Date\('([^']+)'\)/);
            if (dateMatch) {
                canProceedAfter = new Date(dateMatch[1]);
                console.log('Found can_proceed_after:', canProceedAfter);
            }
        }
    });
    
    if (canProceedAfter) {
        console.log('Starting timer with end time:', canProceedAfter);
        startCountdownTimer(canProceedAfter, countdownTimer, quizSection);
    } else {
        console.log('Could not find timer end date, trying alternative method...');
        
        // Fallback: look for "za X minut" text and calculate
        const progressSection = document.querySelector('[class*="bg-green-50"]');
        if (progressSection) {
            const progressText = progressSection.textContent;
            console.log('Progress text to search:', progressText);
            
            // Try different regex patterns for Polish text
            const timeMatch = progressText.match(/za\s*(\d+)\s*minut/i) || 
                             progressText.match(/(\d+)\s*minut/i) ||
                             progressText.match(/dostępna\s+za\s*:\s*(\d+):(\d+)/i);
            
            if (timeMatch) {
                let minutes;
                if (timeMatch[2]) {
                    // Format: "X:Y" (minutes:seconds)
                    minutes = parseInt(timeMatch[1]);
                    const seconds = parseInt(timeMatch[2]);
                    const totalSeconds = minutes * 60 + seconds;
                    const endTime = new Date(Date.now() + totalSeconds * 1000);
                    console.log('Found timer from MM:SS format:', minutes + ':' + seconds);
                    startCountdownTimer(endTime, countdownTimer, quizSection);
                } else {
                    // Format: "X minut"
                    minutes = parseInt(timeMatch[1]);
                    console.log('Found timer duration from text:', minutes, 'minutes');
                    
                    // Calculate end time (current time + minutes)
                    const endTime = new Date(Date.now() + minutes * 60 * 1000);
                    console.log('Calculated timer end time:', endTime);
                    
                    // Start the countdown
                    startCountdownTimer(endTime, countdownTimer, quizSection);
                }
            } else {
                console.log('Could not extract timer duration from text:', progressText);
                
                // Last resort: check if countdown-timer already has a time
                if (countdownTimer && countdownTimer.textContent !== '--:--') {
                    console.log('Timer element has content:', countdownTimer.textContent);
                    const existingTime = countdownTimer.textContent.match(/(\d+):(\d+)/);
                    if (existingTime) {
                        const mins = parseInt(existingTime[1]);
                        const secs = parseInt(existingTime[2]);
                        const totalSeconds = mins * 60 + secs;
                        const endTime = new Date(Date.now() + totalSeconds * 1000);
                        console.log('Using existing timer value:', mins + ':' + secs);
                        startCountdownTimer(endTime, countdownTimer, quizSection);
                    }
                }
            }
        }
    }
}

// Start countdown timer with real-time updates
function startCountdownTimer(endTime, timerElement, quizSection) {
    console.log('startCountdownTimer called with end time:', endTime);
    
    function updateCountdown() {
        const now = new Date();
        const timeLeft = endTime - now;
        
        if (timeLeft <= 0) {
            console.log('Timer expired');
            timerElement.textContent = '0:00';
            
            // Clear interval
            if (window.countdownInterval) {
                clearInterval(window.countdownInterval);
            }
            
            // Hide countdown and show quiz button if available
            if (timerElement.closest('div')) {
                timerElement.closest('div').style.display = 'none';
            }
            
            if (quizSection) {
                quizSection.style.display = 'block';
            } else {
                console.log('No quiz section found');
                // Show completion message
                timerElement.textContent = 'Ukończono!';
                if (timerElement.closest('div')) {
                    timerElement.closest('div').style.display = 'block';
                }
            }
            return;
        }
        
        const minutes = Math.floor(timeLeft / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
        const display = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        timerElement.textContent = display;
    }
    
    // Update immediately and then every second
    updateCountdown();
    window.countdownInterval = setInterval(updateCountdown, 1000);
}

// Working timer function for download materials
function startCountdownFromMinutes(minutes, completeUrl) {
    const countdownTimer = document.getElementById('countdown-timer');
    if (!countdownTimer) return;
    
    console.log('Starting countdown from', minutes, 'minutes');
    
    let totalSeconds = minutes * 60;
    
    function updateDisplay() {
        const mins = Math.floor(totalSeconds / 60);
        const secs = totalSeconds % 60;
        const display = mins + ':' + (secs < 10 ? '0' : '') + secs;
        
        countdownTimer.textContent = display;
        
        if (totalSeconds <= 0) {
            console.log('Timer finished, completing lesson...');
            
            // Complete lesson
            if (completeUrl) {
                fetch(completeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        console.log('Lesson completed after timer');
                        countdownTimer.textContent = 'Ukończono!';
                        
                        // Update lesson status in sidebar
                        const lessonItem = document.querySelector('.lesson-item.active');
                        if (lessonItem) {
                            lessonItem.classList.add('completed');
                            const statusElement = lessonItem.querySelector('.lesson-status');
                            if (statusElement) {
                                statusElement.textContent = '✓ Ukończona';
                            }
                        }
                        
                        // Show success message
                        if (data.quiz_unlocked && window.showSuccessMessage) {
                            window.showSuccessMessage('🎉 Wszystkie lekcje ukończone! Test końcowy został odblokowany.');
                        } else if (window.showSuccessMessage) {
                            window.showSuccessMessage('Lekcja została ukończona!');
                        }
                        
                        // Refresh lessons and navigation
                        if (typeof refreshLessonsAccessibility === 'function') {
                            refreshLessonsAccessibility();
                        }
                        
                        setTimeout(() => {
                            if (typeof updateNavigationButtons === 'function') {
                                updateNavigationButtons();
                            }
                        }, 1000);
                    }
                }).catch(error => {
                    console.error('Error completing lesson after timer:', error);
                });
            }
            
            return;
        }
        
        totalSeconds--;
    }
    
    // Update immediately and then every second
    updateDisplay();
    setInterval(updateDisplay, 1000);
}

// Sinusoidal Progress Bar Functions
function updateSinusoidalProgress(percentage) {
    const progressPath = document.querySelector('#progress-path');
    const progressDot = document.querySelector('.progress-dot');
    const progressPulse = document.querySelector('.progress-pulse');
    
    if (!progressPath || !progressDot) return;
    
    // Get path length and calculate progress
    const pathLength = progressPath.getTotalLength();
    const progress = Math.max(0, Math.min(100, percentage)) / 100;
    const progressLength = pathLength * progress;
    
    // Set stroke-dasharray to show progress
    progressPath.style.strokeDasharray = `${progressLength} ${pathLength}`;
    
    // Update gradient color based on progress
    updateProgressGradient(progress);
    
    // Get point along path for dot position
    if (progress > 0) {
        const point = progressPath.getPointAtLength(progressLength);
        progressDot.setAttribute('cx', point.x);
        progressDot.setAttribute('cy', point.y);
        progressPulse.setAttribute('cx', point.x);
        progressPulse.setAttribute('cy', point.y);
        
        // Update dot color based on progress
        updateDotGradient(progress);
    }
}

function interpolateColor(color1, color2, factor) {
    // Convert hex to RGB
    const hex1 = color1.replace('#', '');
    const hex2 = color2.replace('#', '');
    
    const r1 = parseInt(hex1.substr(0, 2), 16);
    const g1 = parseInt(hex1.substr(2, 2), 16);
    const b1 = parseInt(hex1.substr(4, 2), 16);
    
    const r2 = parseInt(hex2.substr(0, 2), 16);
    const g2 = parseInt(hex2.substr(2, 2), 16);
    const b2 = parseInt(hex2.substr(4, 2), 16);
    
    // Interpolate
    const r = Math.round(r1 + (r2 - r1) * factor);
    const g = Math.round(g1 + (g2 - g1) * factor);
    const b = Math.round(b1 + (b2 - b1) * factor);
    
    return `rgb(${r}, ${g}, ${b})`;
}

function updateProgressGradient(progress) {
    const gradient = document.querySelector('#progressGradient');
    const stop1 = gradient.querySelector('stop:first-child');
    const stop2 = gradient.querySelector('stop:last-child');
    
    if (progress < 0.5) {
        // First half: navy to blue
        stop1.setAttribute('stop-color', '#21235F');
        stop2.setAttribute('stop-color', interpolateColor('#21235F', '#3B82F6', progress * 2));
    } else {
        // Second half: blue to green
        stop1.setAttribute('stop-color', interpolateColor('#21235F', '#3B82F6', 1));
        stop2.setAttribute('stop-color', interpolateColor('#3B82F6', '#22C55E', (progress - 0.5) * 2));
    }
}

function updateDotGradient(progress) {
    // Create or update dynamic dot gradient
    const defs = document.querySelector('defs');
    let dynamicGradient = document.querySelector('#dotGradient-dynamic');
    
    if (!dynamicGradient) {
        dynamicGradient = document.createElementNS('http://www.w3.org/2000/svg', 'radialGradient');
        dynamicGradient.setAttribute('id', 'dotGradient-dynamic');
        dynamicGradient.setAttribute('cx', '50%');
        dynamicGradient.setAttribute('cy', '30%');
        
        const stop1 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
        stop1.setAttribute('offset', '0%');
        stop1.setAttribute('stop-color', '#ffffff');
        stop1.setAttribute('stop-opacity', '0.9');
        
        const stop2 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
        stop2.setAttribute('offset', '100%');
        stop2.setAttribute('stop-opacity', '1');
        
        dynamicGradient.appendChild(stop1);
        dynamicGradient.appendChild(stop2);
        defs.appendChild(dynamicGradient);
    }
    
    const stop2 = dynamicGradient.querySelector('stop:last-child');
    const dotColor = interpolateColor('#21235F', '#22C55E', progress);
    stop2.setAttribute('stop-color', dotColor);
    
    // Update dot to use dynamic gradient
    const progressDot = document.querySelector('.progress-dot');
    progressDot.setAttribute('fill', 'url(#dotGradient-dynamic)');
}

// Initialize progress on page load
document.addEventListener('DOMContentLoaded', function() {
    const progressPercentage = {{ $progressPercentage }};
    setTimeout(() => {
        updateSinusoidalProgress(progressPercentage);
    }, 100);
});
</script>
@endsection
