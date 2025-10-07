@extends('layouts.app')

@section('content')

<!-- Motivational Popup System -->
<div id="motivational-popup" class="motivational-popup hidden">
    <div class="popup-content">
        <div class="popup-icon">🎉</div>
        <div class="popup-text"></div>
        <div class="popup-close">&times;</div>
    </div>
</div>
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
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    .course-description {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #4A5568;
        margin-bottom: 1.5rem;
        padding: 1rem 0;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
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
        height: 40px;
        width: 100%;
        overflow: visible;
        margin: 20px 0;
    }

    .sinusoidal-progress {
        width: 100%;
        height: 40px;
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
        transition: cx 1s cubic-bezier(0.4, 0, 0.2, 1);
        shape-rendering: geometricPrecision;
        vector-effect: non-scaling-stroke;
        /* Force hardware acceleration for better rendering */
        will-change: transform;
        /* Ensure visibility in Safari */
        opacity: 1;
        visibility: visible;
        /* Keep circle perfectly round despite preserveAspectRatio="none" */
        transform: scale(1, 1);
        transform-origin: center;
        transform-box: fill-box;
    }

    /* Fix aspect ratio for dot only */
    .sinusoidal-progress circle {
        transform: scaleY(20);
        transform-origin: center;
        transform-box: fill-box;
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

    /* Mobile Sidebar Overlay */
    .mobile-sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        backdrop-filter: blur(5px);
    }

    .mobile-sidebar-overlay.show {
        display: block;
    }

    /* Course Lessons Mobile Button */
    .course-lessons-mobile-button {
        display: none;
        position: fixed;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        width: 45px;
        height: 80px;
        background: rgba(33, 35, 95, 0.95);
        border: none;
        border-radius: 0 15px 15px 0;
        cursor: pointer;
        z-index: 999;
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .course-lessons-mobile-button:hover {
        background: rgba(33, 35, 95, 1);
        transform: translateY(-50%) translateX(5px);
        box-shadow: 5px 0 20px rgba(0, 0, 0, 0.4);
    }

    .hamburger-icon {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        gap: 3px;
    }

    .hamburger-icon span {
        width: 20px;
        height: 2px;
        background: white;
        transition: all 0.3s ease;
        border-radius: 1px;
    }

    .course-lessons-mobile-button.active .hamburger-icon span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .course-lessons-mobile-button.active .hamburger-icon span:nth-child(2) {
        opacity: 0;
    }

    .course-lessons-mobile-button.active .hamburger-icon span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
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
        .breadcrumbs {
            display: none;
        }

        .course-lessons-mobile-button {
            display: block;
        }

        .course-content {
            grid-template-columns: 1fr;
        }

        .chapters-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 320px;
            height: 100vh;
            z-index: 1000;
            transition: left 0.3s ease;
            overflow-y: auto;
            padding-top: 80px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 5px 0 30px rgba(0, 0, 0, 0.2);
        }

        .chapters-sidebar.show {
            left: 0;
        }

        .course-title {
            font-size: 1.5rem;
        }
        .course-header .flex {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .course-description {
            font-size: 1rem;
            padding: 0.75rem 0;
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
        
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h1 class="course-title">{{ $course->title }}</h1>

            @if($course->has_instruction && $course->instruction_content)
                <button type="button" onclick="openInstructionModal()"
                    class="flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 rounded-full text-blue-700 font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full mr-2">
                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    Instrukcja
                </button>
            @endif
        </div>

        @if($course->description)
            <div class="course-description">
                {{ $course->description }}
            </div>
        @endif
    </div>

    <!-- Progress Section -->
    <div class="progress-section">
        <div class="progress-header">
            <div class="progress-title">Postęp kursu</div>
            <div class="progress-percentage">{{ $progressPercentage }}%</div>
        </div>
        <div class="progress-bar-container">
            <svg class="sinusoidal-progress" viewBox="0 0 800 40" preserveAspectRatio="none">
                <!-- Gradient definitions -->
                <defs>
                    <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#21235F" />
                        <stop offset="100%" stop-color="#22C55E" />
                    </linearGradient>
                    <!-- Solid dot gradient (no glow effect) -->
                    <radialGradient id="dotGradient" cx="50%" cy="50%">
                        <stop offset="0%" stop-color="#21235F" stop-opacity="1"/>
                        <stop offset="100%" stop-color="#21235F" stop-opacity="1"/>
                    </radialGradient>
                </defs>

                <!-- Background path (flat horizontal line) -->
                <path id="progress-path-bg" class="progress-path-bg"
                      d="M 0 20 L 800 20"
                      vector-effect="non-scaling-stroke" />

                <!-- Progress path (flat horizontal line) -->
                <path id="progress-path" class="progress-path"
                      stroke="url(#progressGradient)"
                      d="M 0 20 L 800 20"
                      vector-effect="non-scaling-stroke" />

                <!-- Progress dot as circle for perfect round shape -->
                <circle class="progress-dot"
                        cx="0"
                        cy="20"
                        r="10"
                        fill="#21235F"
                        stroke="#ffffff"
                        stroke-width="3"
                        vector-effect="non-scaling-stroke"
                        shape-rendering="geometricPrecision"
                        style="opacity: 1; visibility: visible;" />
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
    <!-- Course Lessons Mobile Menu Button -->
    <button class="course-lessons-mobile-button" onclick="toggleMobileSidebar()">
        <div class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </button>

    <!-- Mobile Sidebar Overlay -->
    <div class="mobile-sidebar-overlay" onclick="closeMobileSidebar()"></div>

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
    console.log('🔍 DEBUG initializeVideoControls called');
    const video = document.getElementById('lesson-video');
    console.log('🔍 DEBUG Video element found:', !!video);

    if (video && !video.hasAttribute('data-initialized')) {
        video.setAttribute('data-initialized', 'true');
        console.log('🔍 DEBUG Video initialized');

        // Log video data attributes
        console.log('🔍 DEBUG Video data attributes:', {
            savePositionUrl: video.dataset.savePositionUrl,
            startPosition: video.dataset.startPosition,
            completeLessonUrl: video.dataset.completeLessonUrl
        });

        // Check if Video.js is loaded
        console.log('🔍 DEBUG Video.js available:', typeof videojs !== 'undefined');

        // Try to call custom Video.js controls (they will handle native controls)
        if (typeof window.initVideoJSPlayer === 'function') {
            console.log('🔍 DEBUG Video.js player function found, calling...');
            try {
                const options = {
                    saveUrl: video.dataset.savePositionUrl,
                    startPosition: video.dataset.startPosition,
                    completeUrl: video.dataset.completeLessonUrl
                };
                console.log('🔍 DEBUG Calling initVideoJSPlayer with options:', options);
                window.initVideoJSPlayer(video, options);
                console.log('🔍 DEBUG Video.js player initialized successfully');
            } catch (error) {
                console.error('🔍 DEBUG Error initializing Video.js player:', error);
                // Fallback to basic controls if Video.js fails
                video.controls = true;
                console.log('🔍 DEBUG Fallback to basic controls due to error');
            }
        } else {
            console.log('🔍 DEBUG Video.js player function not found, using basic controls');
            video.controls = true;
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
    console.log('navigateToQuiz called, canTakeQuiz:', canTakeQuiz);
    
    if(canTakeQuiz) {
        // Update active state - remove active from all lessons
        document.querySelectorAll('.lesson-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Find quiz lesson item and activate it (if it exists)
        const quizLessonItem = document.querySelector('.lesson-item[onclick*="navigateToQuiz"]');
        if (quizLessonItem) {
            quizLessonItem.classList.add('active');
        }
        
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
        console.log('Quiz not available, showing alert');
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
            
            // Check if quiz should be unlocked after lesson update
            console.log('Checking quiz unlock status from server response...');
            if (data.quiz_unlocked) {
                console.log('Quiz was unlocked - showing quiz section in iframe');
                const iframe = document.querySelector('#lesson-content iframe');
                if (iframe) {
                    try {
                        const quizSection = iframe.contentDocument.getElementById('quiz-start-section');
                        if (quizSection) {
                            quizSection.style.display = 'block';
                            console.log('Quiz section shown in iframe');
                        }
                    } catch (e) {
                        console.log('Cannot access iframe content, sending message to iframe');
                        // Send message to iframe to show quiz section
                        iframe.contentWindow.postMessage({action: 'showQuizSection'}, '*');
                    }
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
    
    // Check if current lesson is materials lesson - hide buttons if it is
    const currentLessonTitle = activeLesson.querySelector('.lesson-title');
    if (currentLessonTitle && 
        (currentLessonTitle.textContent.toLowerCase().includes('materiały do pobrania') || 
         currentLessonTitle.textContent.toLowerCase().includes('materialy do pobrania'))) {
        console.log('Current lesson is materials lesson - hiding navigation buttons');
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
        return;
    } else {
        // Show buttons for non-materials lessons
        prevBtn.style.display = 'inline-flex';
        nextBtn.style.display = 'inline-flex';
    }
    
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
        // No next lesson - check if this is the last lesson with materials and if it's completed
        const hasDownloadMaterials = document.querySelector('.material-download') || 
                                   document.querySelector('[data-download-timer]') ||
                                   document.querySelector('#timer-display') ||
                                   document.querySelector('#countdown-timer');
        
        const lessonCompleted = document.querySelector('.bg-green-50 .text-green-600') && 
                              document.querySelector('.bg-green-50 .text-green-600').textContent.includes('Timer zakończony');
        
        console.log('*** LAST LESSON CHECK ***');
        console.log('*** Has materials:', !!hasDownloadMaterials);
        console.log('*** Completed:', lessonCompleted);
        console.log('*** Timer completed element:', document.querySelector('.bg-green-50 .text-green-600'));
        if (document.querySelector('.bg-green-50 .text-green-600')) {
            console.log('*** Timer text:', document.querySelector('.bg-green-50 .text-green-600').textContent);
        }
        
        if (hasDownloadMaterials && lessonCompleted) {
            // Last lesson with materials is completed - show quiz button
            nextBtn.disabled = false;
            nextBtn.className = 'btn btn-primary flex items-center justify-center';
            nextBtn.style.cssText = 'min-width: 200px; height: 50px; background: #2563eb !important; border-color: #2563eb !important;';
            nextBtn.innerHTML = 'Przejdź do testu końcowego →';
            nextBtn.onclick = () => navigateToQuiz();
            console.log('Quiz button enabled for completed last lesson');
        } else {
            // Default: disable next button
            nextBtn.disabled = true;
            nextBtn.className = 'btn btn-primary flex items-center justify-center opacity-50 cursor-not-allowed';
            nextBtn.style.cssText = 'min-width: 150px; height: 50px;';
            nextBtn.innerHTML = 'Następna →';
            nextBtn.onclick = null;
            console.log('Next lesson disabled');
        }
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
    console.log('🔍 DEBUG: initializeCountdownTimer called');
    const countdownTimer = document.getElementById('countdown-timer');
    const timerDisplay = document.getElementById('timer-display');
    const quizSection = document.getElementById('quiz-start-section');
    
    console.log('🔍 DEBUG: countdown-timer element:', countdownTimer);
    console.log('🔍 DEBUG: timer-display element:', timerDisplay);
    console.log('🔍 DEBUG: quiz-start-section element:', quizSection);
    
    // Check for either countdown-timer or timer-display
    const activeTimer = countdownTimer || timerDisplay;
    
    if (!activeTimer) {
        console.log('🔍 DEBUG: No countdown timer found');
        return;
    }
    
    console.log('🔍 DEBUG: Timer found:', activeTimer.id);
    console.log('🔍 DEBUG: Timer content:', activeTimer.textContent);
    console.log('🔍 DEBUG: Timer HTML:', activeTimer.outerHTML);
    
    // If it's timer-display, it already has JavaScript in lesson-content.blade.php
    if (activeTimer.id === 'timer-display') {
        console.log('timer-display found - JavaScript already handled in lesson-content');
        return;
    }
    
    // If countdown-timer shows --:--, it means PHP didn't initialize it properly
    if (activeTimer.id === 'countdown-timer' && activeTimer.textContent === '--:--') {
        console.log('🔍 DEBUG: countdown-timer shows --:--, trying to find lesson timer data...');
        console.log('🔍 DEBUG: Current page URL:', window.location.href);
        console.log('🔍 DEBUG: Document title:', document.title);
        
        // First check if there's existing can_proceed_after data from server
        let canProceedAfter = null;
        const scriptTags = document.querySelectorAll('script');
        console.log('🔍 DEBUG: Found', scriptTags.length, 'script tags');
        
        scriptTags.forEach((script, index) => {
            const scriptContent = script.textContent;
            if (scriptContent && scriptContent.includes('can_proceed_after')) {
                console.log('🔍 DEBUG: Script', index, 'contains can_proceed_after');
                console.log('🔍 DEBUG: Script content preview:', scriptContent.substring(0, 500));
                
                // Try multiple regex patterns
                let dateMatch = scriptContent.match(/can_proceed_after.*?new Date\('([^']+)'\)/);
                if (!dateMatch) {
                    dateMatch = scriptContent.match(/canProceedAfter = new Date\('([^']+)'\)/);
                }
                if (!dateMatch) {
                    dateMatch = scriptContent.match(/new Date\('([^']+)'\)/);
                }
                
                if (dateMatch) {
                    canProceedAfter = new Date(dateMatch[1]);
                    console.log('🔍 DEBUG: Found existing can_proceed_after:', canProceedAfter);
                    console.log('🔍 DEBUG: Current time:', new Date());
                    console.log('🔍 DEBUG: Time difference (ms):', canProceedAfter - new Date());
                } else {
                    console.log('🔍 DEBUG: Script contains can_proceed_after but no date match found');
                    console.log('🔍 DEBUG: Full script content:', scriptContent);
                }
            }
        });
        
        if (canProceedAfter && canProceedAfter > new Date()) {
            // Use existing timer from database
            const remainingSeconds = Math.floor((canProceedAfter - new Date()) / 1000);
            console.log('🔍 DEBUG: Using existing timer with', remainingSeconds, 'seconds remaining');
            startCountdownFromSeconds(remainingSeconds, null);
            return;
        } else {
            console.log('🔍 DEBUG: No valid can_proceed_after found or timer expired');
        }
        
        // Look for download buttons to get timer duration (fallback for new downloads)
        const downloadButtons = document.querySelectorAll('.material-download');
        console.log('🔍 DEBUG: Found', downloadButtons.length, 'download buttons');
        
        if (downloadButtons.length > 0) {
            const timerMinutes = parseInt(downloadButtons[0].dataset.downloadTimer) || 2;
            console.log('🔍 DEBUG: Found download timer:', timerMinutes, 'minutes');
            console.log('🔍 DEBUG: Download button dataset:', downloadButtons[0].dataset);
            
            // Start countdown from the download timer value
            startCountdownFromMinutes(timerMinutes, downloadButtons[0].dataset.completeLessonUrl);
            return;
        } else {
            console.log('🔍 DEBUG: No download buttons found');
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

// Timer function for remaining seconds from database
function startCountdownFromSeconds(totalSeconds, completeUrl) {
    const countdownTimer = document.getElementById('countdown-timer');
    if (!countdownTimer) {
        console.log('🔍 DEBUG: startCountdownFromSeconds - no countdown timer found');
        return;
    }
    
    console.log('🔍 DEBUG: startCountdownFromSeconds called with', totalSeconds, 'seconds');
    console.log('🔍 DEBUG: completeUrl:', completeUrl);
    
    function updateDisplay() {
        const mins = Math.floor(totalSeconds / 60);
        const secs = totalSeconds % 60;
        const display = mins + ':' + (secs < 10 ? '0' : '') + secs;
        
        countdownTimer.textContent = display;
        
        if (totalSeconds <= 0) {
            console.log('Timer finished');
            countdownTimer.textContent = 'Ukończono!';
            clearInterval(window.timerInterval);
            
            // Unlock quiz when timer finishes
            canTakeQuiz = true;
            console.log('Quiz unlocked after timer completion, canTakeQuiz is now:', canTakeQuiz);
            
            // Show quiz section if available
            const quizSection = document.getElementById('quiz-start-section');
            if (quizSection) {
                quizSection.style.display = 'block';
                console.log('Quiz section shown');
            } else {
                console.log('Quiz section not found');
            }
            
            // Update navigation buttons to show quiz option
            setTimeout(() => {
                if (typeof updateNavigationButtons === 'function') {
                    updateNavigationButtons();
                }
            }, 500);
            
            return;
        }
        
        totalSeconds--;
    }
    
    // Clear any existing interval
    if (window.timerInterval) {
        clearInterval(window.timerInterval);
    }
    
    updateDisplay();
    window.timerInterval = setInterval(updateDisplay, 1000);
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
            
            // Always unlock quiz when timer finishes
            canTakeQuiz = true;
            console.log('Quiz unlocked after timer completion, canTakeQuiz is now:', canTakeQuiz);
            
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
                        
                        // Unlock quiz when lesson completes after timer
                        if (data.quiz_unlocked) {
                            canTakeQuiz = true;
                            console.log('Quiz unlocked after lesson completion');
                        }
                        
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
            } else {
                // No completeUrl but timer finished - still show quiz section and update buttons
                const quizSection = document.getElementById('quiz-start-section');
                if (quizSection) {
                    quizSection.style.display = 'block';
                }
                
                // Update navigation buttons to show quiz option
                setTimeout(() => {
                    if (typeof updateNavigationButtons === 'function') {
                        updateNavigationButtons();
                    }
                }, 500);
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
let lastProgressPercentage = -1;

function updateSinusoidalProgress(percentage) {
    const progressPath = document.querySelector('#progress-path');
    const progressDot = document.querySelector('.progress-dot');
    
    if (!progressPath || !progressDot) return;
    
    try {
        // Check if progress actually changed
        const isProgressChanging = lastProgressPercentage !== percentage;
        lastProgressPercentage = percentage;
        
        // Get path length and calculate progress
        const pathLength = progressPath.getTotalLength();
        const progress = Math.max(0, Math.min(100, percentage)) / 100;
        const progressLength = Math.max(0, Math.min(pathLength, pathLength * progress));
        
        // Set stroke-dasharray to show progress
        progressPath.style.strokeDasharray = `${progressLength} ${pathLength}`;
        
        // Update gradient color based on progress
        updateProgressGradient(progress);
        
        // Get point along path for dot position with bounds checking
        if (progress > 0 && progressLength > 0) {
            const point = progressPath.getPointAtLength(progressLength);
            
            // Validate coordinates and apply bounds
            const svgRect = progressPath.closest('svg').getBoundingClientRect();
            const viewBox = progressPath.closest('svg').getAttribute('viewBox').split(' ');
            const maxX = parseFloat(viewBox[2]) || 800;
            const maxY = parseFloat(viewBox[3]) || 40;

            // Clamp coordinates within valid bounds
            const x = Math.max(0, Math.min(maxX, point.x || 0));
            const y = Math.max(0, Math.min(maxY, point.y || 20));
            
            // Only update if coordinates are valid numbers
            if (!isNaN(x) && !isNaN(y) && isFinite(x) && isFinite(y)) {
                progressDot.setAttribute('cx', x);
                progressDot.setAttribute('cy', y);

                // Ensure the circle radius is explicitly set for Chrome compatibility
                if (!progressDot.getAttribute('r')) progressDot.setAttribute('r', '10');
                progressDot.setAttribute('vector-effect', 'non-scaling-stroke');
                progressDot.setAttribute('shape-rendering', 'geometricPrecision');

                // Force re-render for Safari by toggling visibility
                progressDot.style.opacity = '0.99';
                setTimeout(() => {
                    progressDot.style.opacity = '1';
                }, 10);

                // Update dot color based on progress
                updateDotColor(progress);
            } else {
                console.warn('Invalid coordinates calculated:', {x, y, point});
            }
        } else {
            // Position at start when progress is 0
            progressDot.setAttribute('cx', 0);
            progressDot.setAttribute('cy', 20);
        }
    } catch (error) {
        console.error('Error updating progress:', error);
        // Fallback to start position
        progressDot.setAttribute('cx', 0);
        progressDot.setAttribute('cy', 20);
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

function updateDotColor(progress) {
    // Update dot with solid color based on progress
    const progressDot = document.querySelector('.progress-dot');
    if (!progressDot) return;

    const dotColor = interpolateColor('#21235F', '#22C55E', progress);
    progressDot.setAttribute('fill', dotColor);

    // Ensure stroke is visible for better definition
    progressDot.setAttribute('stroke', '#ffffff');
    progressDot.setAttribute('stroke-width', '2');
    progressDot.setAttribute('vector-effect', 'non-scaling-stroke');
    progressDot.setAttribute('shape-rendering', 'geometricPrecision');

    // Force re-render for Safari compatibility
    progressDot.style.fill = dotColor;
}

// Initialize progress on page load
document.addEventListener('DOMContentLoaded', function() {
    const progressPercentage = {{ $progressPercentage }};

    // Initialize progress with validation
    setTimeout(() => {
        // Ensure percentage is a valid number
        const validPercentage = Math.max(0, Math.min(100, progressPercentage || 0));
        console.log('Initializing progress with:', validPercentage + '%');

        // Ensure progress dot is visible before animation
        const progressDot = document.querySelector('.progress-dot');
        if (progressDot) {
            // Force initial attributes for cross-browser compatibility
            progressDot.setAttribute('r', '8');
            progressDot.setAttribute('cx', '0');
            progressDot.setAttribute('cy', '60');
            progressDot.setAttribute('fill', '#21235F');
            progressDot.setAttribute('stroke', '#ffffff');
            progressDot.setAttribute('stroke-width', '2');
            progressDot.setAttribute('vector-effect', 'non-scaling-stroke');
            progressDot.setAttribute('shape-rendering', 'geometricPrecision');
            progressDot.style.opacity = '1';
            progressDot.style.visibility = 'visible';
        }

        updateSinusoidalProgress(validPercentage);
    }, 100);
    
    // Add resize listener to recalculate positions and scale if needed
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            // Ensure circle remains properly sized on resize
            const progressDot = document.querySelector('.progress-dot');
            if (progressDot) {
                progressDot.setAttribute('r', '8');
            }

            const validPercentage = Math.max(0, Math.min(100, progressPercentage || 0));
            updateSinusoidalProgress(validPercentage);
        }, 200);
    });
});

// Motivational Popup System
const motivationalMessages = [
    { text: "Świetnie Ci idzie! 💪", icon: "🎉" },
    { text: "Jesteś na dobrej drodze! 🌟", icon: "✨" },
    { text: "Tak trzymaj! 🚀", icon: "🔥" },
    { text: "Doskonała robota! 👏", icon: "🎊" },
    { text: "Imponująca koncentracja! 🧠", icon: "💡" },
    { text: "Uczysz się szybko! ⚡", icon: "🎯" },
    { text: "Brawo! Kontynuuj! 🌈", icon: "🏆" },
    { text: "Jesteś coraz bliżej celu! 🎯", icon: "🎪" },
    { text: "Fantastyczny postęp! 📈", icon: "🌟" },
    { text: "Nie poddawaj się! 💪", icon: "🦋" }
];

let lastMotivationalShow = 0;
let motivationalCounter = 0;

function showMotivationalPopup() {
    const now = Date.now();
    // Nie częściej niż co 2 minuty
    if (now - lastMotivationalShow < 120000) return;
    
    const popup = document.getElementById('motivational-popup');
    if (!popup || popup.classList.contains('show')) return;
    
    const randomMessage = motivationalMessages[Math.floor(Math.random() * motivationalMessages.length)];
    
    popup.querySelector('.popup-text').textContent = randomMessage.text;
    popup.querySelector('.popup-icon').textContent = randomMessage.icon;
    
    popup.classList.remove('hidden');
    setTimeout(() => popup.classList.add('show'), 10);
    
    lastMotivationalShow = now;
    motivationalCounter++;
    
    // Auto-hide po 4 sekundach
    setTimeout(() => {
        hideMotivationalPopup();
    }, 4000);
}

function hideMotivationalPopup() {
    const popup = document.getElementById('motivational-popup');
    if (!popup) return;
    
    popup.classList.remove('show');
    setTimeout(() => popup.classList.add('hidden'), 300);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const closeBtn = document.querySelector('.popup-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', hideMotivationalPopup);
    }
    
    // Random triggers
    setTimeout(() => {
        if (Math.random() < 0.3) showMotivationalPopup();
    }, Math.random() * 30000 + 10000); // 10-40s po załadowaniu
    
    // Periodic random shows
    setInterval(() => {
        if (Math.random() < 0.1) showMotivationalPopup(); // 10% szansy co minutę
    }, 60000);
});

// Trigger na akcje użytkownika
function triggerMotivationalChance() {
    if (Math.random() < 0.15) { // 15% szansy
        setTimeout(() => showMotivationalPopup(), 1000 + Math.random() * 3000);
    }
}

// Hook do istniejących event handlerów
const originalLessonLoad = window.loadLesson;
window.loadLesson = function(...args) {
    if (originalLessonLoad) originalLessonLoad.apply(this, args);
    triggerMotivationalChance();
    // Close mobile sidebar when lesson is loaded
    closeMobileSidebar();
};

// Mobile Sidebar Functions for Course Lessons
function toggleMobileSidebar() {
    const sidebar = document.querySelector('.chapters-sidebar');
    const overlay = document.querySelector('.mobile-sidebar-overlay');
    const button = document.querySelector('.course-lessons-mobile-button');

    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
    button.classList.toggle('active');
}

function closeMobileSidebar() {
    const sidebar = document.querySelector('.chapters-sidebar');
    const overlay = document.querySelector('.mobile-sidebar-overlay');
    const button = document.querySelector('.course-lessons-mobile-button');

    sidebar.classList.remove('show');
    overlay.classList.remove('show');
    button.classList.remove('active');
}

// Hook do ukończenia lekcji  
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('lesson-item') || e.target.closest('.lesson-item')) {
        triggerMotivationalChance();
    }
});
</script>

<style>
.motivational-popup {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 320px;
    transition: all 0.3s ease-in-out;
}

.motivational-popup.hidden {
    opacity: 0;
    transform: translateX(100px) translateY(-20px);
    pointer-events: none;
}

.motivational-popup.show {
    opacity: 1;
    transform: translateX(0) translateY(0);
}

.popup-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px 20px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    position: relative;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: bounce 0.5s ease-out;
}

.popup-content::before {
    content: '';
    position: absolute;
    top: 50%;
    right: -8px;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border: 8px solid transparent;
    border-left-color: #667eea;
}

.popup-icon {
    font-size: 24px;
    animation: pulse 1.5s infinite;
}

.popup-text {
    flex: 1;
    font-weight: 500;
    font-size: 14px;
    line-height: 1.4;
}

.popup-close {
    cursor: pointer;
    font-size: 20px;
    opacity: 0.8;
    transition: opacity 0.2s;
}

.popup-close:hover {
    opacity: 1;
}

@keyframes bounce {
    0% { transform: scale(0.8) translateY(20px); opacity: 0; }
    50% { transform: scale(1.05) translateY(-5px); opacity: 0.8; }
    100% { transform: scale(1) translateY(0); opacity: 1; }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

@media (max-width: 768px) {
    .motivational-popup {
        top: 10px;
        right: 10px;
        left: 10px;
        max-width: none;
    }
}

/* Main Footer Styles (same as welcome page) */
.footer {
    background-image: url('/images/backgrounds/wave.png');
    background-size: cover;
    background-position: center;
    background-color: #21235F;
    background-blend-mode: overlay;
    position: relative;
    color: white;
    padding: 4rem 0 2rem 0;
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
    grid-template-columns: 2fr 1fr 1fr 1fr;
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
    height: auto;
    filter: brightness(0) invert(1);
    margin-bottom: 20px;
}

.footer-description {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
}

.footer-center, .footer-right, .footer-patronage {
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
    margin-bottom: 0.5rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.footer-link {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.footer-link:hover {
    color: white;
    text-decoration: underline;
}

.footer-bottom {
    max-width: 1200px;
    margin: 2rem auto 0;
    padding: 2rem 2rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.3);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    position: relative;
    z-index: 2;
    color: rgba(255, 255, 255, 0.8);
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
}

.footer-admin-link:hover {
    opacity: 0.8;
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }

    .footer-bottom {
        flex-direction: column;
        text-align: center;
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
                <li><a href="{{ route('privacy') }}" class="footer-link">Polityka Prywatności</a></li>
                <li><a href="{{ route('cookies') }}" class="footer-link">Polityka Plików Cookies</a></li>
                <li><a href="#" onclick="openCookieModal(); return false;" class="footer-link">Zarządzanie cookies</a></li>
            </ul>
        </div>

        <div class="footer-right">
            <h3 class="footer-section-title">Linki</h3>
            <ul class="footer-links">
                <li><a href="{{ route('courses') }}" class="footer-link">Szkolenia</a></li>
                <li><a href="{{ route('contact') }}" class="footer-link">Kontakt</a></li>
            </ul>
        </div>

        <div class="footer-patronage">
            <h3 class="footer-section-title" style="text-align: center;">Patronat Merytoryczny</h3>
            <div style="display: flex; align-items: center; justify-content: center; margin-top: 1rem;">
                <img src="/images/icons/gumed.png?v=2" alt="GUMed" style="height: 120px; width: auto;">
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-left">
            <div style="display: flex; align-items: flex-end;">
                <span>&copy; 2025 Wszelkie Prawa zastrzeżone</span>
                <img src="/images/icons/lekam.png" alt="Lekam" style="height: 24px; margin-left: 8px; margin-bottom: 6px; vertical-align: bottom;">
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

<!-- Instruction Modal Component -->
<x-instruction-modal :course="$course" />

@endsection
