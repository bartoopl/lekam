<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RepresentativeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Button system demo route
Route::get('/button-demo', function () {
    return view('button-demo');
})->name('button-demo');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/cookies', [HomeController::class, 'cookies'])->name('cookies');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses');

// Representative registration route
Route::get('/register/{code}', function ($code) {
    return redirect()->route('register', ['ref' => $code]);
})->name('register.representative');

// Course routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/lesson/{lesson}', [CourseController::class, 'loadLesson'])->name('courses.load-lesson');
    Route::post('/courses/{course}/lesson/{lesson}/complete', [CourseController::class, 'completeLesson'])->name('courses.complete-lesson');
    Route::post('/courses/{course}/lesson/{lesson}/save-video-position', [CourseController::class, 'saveVideoPosition'])->name('courses.save-video-position');
    Route::get('/courses/{course}/lesson/{lesson}/download', [CourseController::class, 'downloadFile'])->name('courses.download-file');
    Route::post('/courses/{course}/lesson/{lesson}/download', [CourseController::class, 'downloadFile'])->name('courses.download-file.post');
    Route::get('/courses/{course}/lesson/{lesson}/video/download', [CourseController::class, 'downloadVideo'])->name('courses.download-video');
    
    // Route for getting lessons status (AJAX)
    Route::get('/courses/{course}/lessons-status', [CourseController::class, 'getLessonsStatus'])->name('courses.lessons-status');
    
    // Route for getting lesson navigation (AJAX)
    Route::get('/courses/{course}/lesson/{lesson}/navigation', [CourseController::class, 'getLessonNavigation'])->name('courses.lesson-navigation');
    
    // Test route for resetting course progress (only in debug/local mode)
    Route::post('/courses/{course}/reset-progress', [CourseController::class, 'resetProgress'])->name('courses.reset-progress');
    
    // Course enrollment route
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
});
Route::get('/courses/{course}/progress', [CourseController::class, 'progress'])->name('courses.progress');

// Quiz routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/courses/{course}/quiz', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/courses/{course}/quiz/content', [QuizController::class, 'loadContent'])->name('quizzes.load-content');
    Route::post('/courses/{course}/quiz/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::get('/courses/{course}/quiz/take/{attempt}', [QuizController::class, 'take'])->name('quizzes.take');
    Route::get('/courses/{course}/quiz/questions/{attempt}', [QuizController::class, 'loadQuestions'])->name('quizzes.load-questions');
    Route::post('/courses/{course}/quiz/submit/{attempt}', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/courses/{course}/quiz/result/{attempt}', [QuizController::class, 'result'])->name('quizzes.result');
});

// Certificate routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('certificates.show');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
    Route::post('/courses/{course}/certificate/generate', [CertificateController::class, 'generate'])->name('certificates.generate');
});

// Admin routes (authenticated and admin access)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
    Route::get('/courses/create', [AdminController::class, 'courseCreate'])->name('courses.create');
    Route::post('/courses', [AdminController::class, 'courseStore'])->name('courses.store');
    Route::get('/courses/{course}', [AdminController::class, 'courseShow'])->name('courses.show');
    Route::get('/courses/{course}/edit', [AdminController::class, 'courseEdit'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminController::class, 'courseUpdate'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminController::class, 'courseDestroy'])->name('courses.destroy');
    Route::delete('/courses/{course}/image', [AdminController::class, 'removeCourseImage'])->name('courses.remove-image');
    
    // Quiz management
    Route::get('/courses/{course}/quiz/create', [AdminController::class, 'quizCreate'])->name('quizzes.create');
    Route::post('/courses/{course}/quiz', [AdminController::class, 'quizStore'])->name('quizzes.store');
    Route::get('/courses/{course}/quiz/{quiz}/edit', [AdminController::class, 'quizEdit'])->name('quizzes.edit');
    Route::put('/courses/{course}/quiz/{quiz}', [AdminController::class, 'quizUpdate'])->name('quizzes.update');
    Route::delete('/courses/{course}/quiz/{quiz}', [AdminController::class, 'quizDestroy'])->name('quizzes.destroy');
    
    // Question management
    Route::get('/courses/{course}/quiz/{quiz}/questions/create', [AdminController::class, 'questionCreate'])->name('questions.create');
    Route::post('/courses/{course}/quiz/{quiz}/questions', [AdminController::class, 'questionStore'])->name('questions.store');
    Route::get('/courses/{course}/quiz/{quiz}/questions/{question}/edit', [AdminController::class, 'questionEdit'])->name('questions.edit');
    Route::put('/courses/{course}/quiz/{quiz}/questions/{question}', [AdminController::class, 'questionUpdate'])->name('questions.update');
    Route::delete('/courses/{course}/quiz/{quiz}/questions/{question}', [AdminController::class, 'questionDestroy'])->name('questions.destroy');
    
    // Chapters management
    Route::get('/courses/{course}/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
    Route::post('/courses/{course}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
    Route::get('/courses/{course}/chapters/{chapter}/edit', [ChapterController::class, 'edit'])->name('chapters.edit');
    Route::put('/courses/{course}/chapters/{chapter}', [ChapterController::class, 'update'])->name('chapters.update');
    Route::delete('/courses/{course}/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    
    // Lessons management
    Route::get('/courses/{course}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/courses/{course}/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/courses/{course}/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/courses/{course}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
    Route::get('/courses/{course}/lessons/{lesson}/materials/{materialIndex}/download', [LessonController::class, 'downloadMaterial'])->name('lessons.download-material');
    Route::get('/courses/{course}/lessons/{lesson}/video/download', [LessonController::class, 'downloadVideo'])->name('lessons.download-video');
    
    // Instructors management
    Route::resource('instructors', InstructorController::class);
    
    // Representatives management
    Route::resource('representatives', RepresentativeController::class);
    Route::post('/representatives/{representative}/generate-code', [RepresentativeController::class, 'generateNewCode'])->name('representatives.generate-code');
    
    Route::get('/certificates', [AdminController::class, 'certificates'])->name('certificates');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
});

// Video proxy for HTTPS compatibility (requires auth or valid referer)
Route::get('/video-proxy', function(Illuminate\Http\Request $request) {
    $url = $request->query('url');
    if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
        abort(400, 'Invalid URL');
    }
    
    // Security check - only allow specific domains
    $allowedDomains = ['grupaneo.beep.pl'];
    $parsedUrl = parse_url($url);
    if (!in_array($parsedUrl['host'], $allowedDomains)) {
        abort(403, 'Domain not allowed');
    }
    
    // Check if user is authenticated OR request comes from our domain (for VideoJS)
    $isAuthenticated = auth()->check();
    $referer = $request->header('referer');
    $isValidReferer = $referer && (
        str_contains($referer, 'lekam.tojest.dev') || 
        str_contains($referer, 'localhost') ||
        str_contains($referer, '127.0.0.1')
    );
    
    if (!$isAuthenticated && !$isValidReferer) {
        abort(403, 'Access denied');
    }
    
    return response()->stream(function() use ($url, $request) {
        // Create context with proper headers for external video server
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: ' . ($request->header('user-agent') ?: 'Mozilla/5.0 (compatible; VideoProxy/1.0)'),
                    'Accept: video/mp4,video/*,*/*',
                    'Accept-Encoding: identity',
                    'Connection: close'
                ],
                'timeout' => 30,
                'ignore_errors' => false
            ]
        ]);
        
        $stream = fopen($url, 'r', false, $context);
        if ($stream) {
            fpassthru($stream);
            fclose($stream);
        }
    }, 200, [
        'Content-Type' => 'video/mp4',
        'Accept-Ranges' => 'bytes',
        'Cache-Control' => 'public, max-age=3600'
    ]);
})->name('video.proxy');

// Default Laravel Breeze routes
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
