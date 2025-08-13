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
        height: 16px;
        background: rgba(33, 35, 95, 0.2) !important;
        border-radius: 8px;
        overflow: visible !important;
        border: 1px solid rgba(33, 35, 95, 0.3);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }

    .progress-bar-fill {
        height: 100% !important;
        background: linear-gradient(90deg, #3B82F6 0%, #1D4ED8 100%) !important;
        border-radius: 8px;
        transition: width 0.3s ease;
        position: relative;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        min-width: 8px !important;
    }

    .progress-bar-circle {
        position: absolute !important;
        right: -6px !important;
        top: -3px !important;
        width: 18px !important;
        height: 18px !important;
        background: #3B82F6 !important;
        border: 3px solid white !important;
        border-radius: 50% !important;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3) !important;
        z-index: 10 !important;
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
        max-height: 500px;
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
            <div class="progress-bar-fill" style="width: {{ $progressPercentage }}%">
                <div class="progress-bar-circle"></div>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-600">
            {{ $completedLessons }} z {{ $totalLessons }} lekcji ukończonych
        </div>
        
        <!-- Test Reset Button -->
        @if(config('app.debug') || app()->environment('local'))
            <div class="mt-4 p-3 bg-yellow-100 border border-yellow-300 rounded-md">
                <div class="flex items-center justify-between">
                    <div class="text-yellow-800 text-sm">
                        <strong>🧪 Tryb testowy:</strong> Przycisk do resetowania postępu
                    </div>
                    <button onclick="resetCourseProgress()" 
                            class="bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700 transition duration-300">
                        Resetuj postęp kursu
                    </button>
                </div>
            </div>
        @endif
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
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                                Rozpocznij naukę
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="no-lesson-selected">
                    <div>
                        <h3>Wybierz lekcję z listy po lewej stronie</h3>
                        <p>Aby rozpocząć naukę, kliknij na jedną z lekcji w spisie tematów.</p>
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
        if (typeof window.initCustomVideoControls === 'function') {
            console.log('Custom controls function found, calling...');
            try {
                window.initCustomVideoControls(video);
                console.log('Custom controls initialized successfully');
            } catch (error) {
                console.error('Error initializing custom controls:', error);
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
                const progressBar = document.querySelector('.progress-bar-fill');
                const progressPercentage = document.querySelector('.progress-percentage');
                const progressText = document.querySelector('.progress-section .text-sm');
                
                if (progressBar) {
                    progressBar.style.width = data.progress_percentage + '%';
                }
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
                prevBtn.className = 'inline-flex items-center justify-center px-6 py-3 bg-blue-600 border-2 border-blue-600 rounded-full font-semibold text-sm text-white tracking-wide cursor-pointer transition-all duration-300 shadow-lg hover:shadow-xl hover:bg-blue-700';
                prevBtn.style.cssText = 'background: #2563eb !important; border-color: #2563eb !important; min-width: 150px; height: 50px; color: white !important;';
                prevBtn.innerHTML = '← Poprzednia';
                prevBtn.onclick = () => loadLesson(parseInt(prevIdMatch[1]), prevTitleMatch[1]);
                console.log('Previous lesson enabled:', prevTitleMatch[1]);
            }
        }
    } else {
        prevBtn.disabled = true;
        prevBtn.className = 'inline-flex items-center justify-center px-6 py-3 bg-gray-400 border-2 border-gray-400 rounded-full font-semibold text-sm text-white tracking-wide cursor-not-allowed transition-all duration-300 shadow-lg hover:shadow-xl';
        prevBtn.style.cssText = 'background: #9ca3af !important; border-color: #9ca3af !important; min-width: 150px; height: 50px; color: white !important;';
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
                nextBtn.className = 'inline-flex items-center justify-center px-6 py-3 bg-blue-600 border-2 border-blue-600 rounded-full font-semibold text-sm text-white tracking-wide cursor-pointer transition-all duration-300 shadow-lg hover:shadow-xl hover:bg-blue-700';
                nextBtn.style.cssText = 'background: #2563eb !important; border-color: #2563eb !important; min-width: 150px; height: 50px; color: white !important;';
                nextBtn.innerHTML = 'Następna →';
                nextBtn.onclick = () => loadLesson(parseInt(nextIdMatch[1]), nextTitleMatch[1]);
                console.log('Next lesson enabled:', nextTitleMatch[1]);
            }
        }
    } else {
        nextBtn.disabled = true;
        nextBtn.className = 'inline-flex items-center justify-center px-6 py-3 bg-gray-400 border-2 border-gray-400 rounded-full font-semibold text-sm text-white tracking-wide cursor-not-allowed transition-all duration-300 shadow-lg hover:shadow-xl';
        nextBtn.style.cssText = 'background: #9ca3af !important; border-color: #9ca3af !important; min-width: 150px; height: 50px; color: white !important;';
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
</script>
@endsection
