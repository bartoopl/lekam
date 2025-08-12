<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Show quiz
     */
    public function show(Course $course)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if course is completed
        if (!$course->isCompletedByUser($user)) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'Musisz ukończyć wszystkie lekcje przed przystąpieniem do testu.');
        }

        $quiz = $course->quiz;
        
        if (!$quiz || !$quiz->is_active) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'Test nie jest dostępny.');
        }

        // Check if user has already passed
        if ($quiz->hasUserPassed($user)) {
            return redirect()->route('courses.show', $course)
                ->with('info', 'Już ukończyłeś ten test.');
        }

        $bestAttempt = $quiz->getUserBestAttempt($user);

        return view('quizzes.show', compact('course', 'quiz', 'bestAttempt'));
    }

    /**
     * Load quiz content for AJAX (similar to lesson content)
     */
    public function loadContent(Course $course)
    {
        \Log::info('Quiz loadContent called', ['course_id' => $course->id]);
        
        $user = Auth::user();
        
        if (!$user) {
            \Log::error('User not authenticated in loadContent');
            return response('Unauthorized', 401);
        }

        // Check if course is completed
        $courseCompleted = $course->isCompletedByUser($user);
        \Log::info('Course completion check', ['course_id' => $course->id, 'user_id' => $user->id, 'completed' => $courseCompleted]);
        
        if (!$courseCompleted) {
            \Log::warning('Course not completed, showing error');
            return response()->view('courses.quiz-content', [
                'error' => 'Musisz ukończyć wszystkie lekcje przed przystąpieniem do testu.',
                'course' => $course
            ]);
        }

        $quiz = $course->quiz;
        
        if (!$quiz || !$quiz->is_active) {
            \Log::error('Quiz not available', ['quiz_id' => $quiz?->id, 'is_active' => $quiz?->is_active]);
            return response()->view('courses.quiz-content', [
                'error' => 'Test nie jest dostępny.',
                'course' => $course
            ]);
        }

        // Check if user has already passed
        $hasPassed = $quiz->hasUserPassed($user);
        \Log::info('Quiz pass check', ['quiz_id' => $quiz->id, 'user_id' => $user->id, 'has_passed' => $hasPassed]);
        
        if ($hasPassed) {
            \Log::info('User already passed, showing info');
            return response()->view('courses.quiz-content', [
                'info' => 'Już ukończyłeś ten test.',
                'course' => $course,
                'quiz' => $quiz,
                'bestAttempt' => $quiz->getUserBestAttempt($user)
            ]);
        }

        $bestAttempt = $quiz->getUserBestAttempt($user);
        \Log::info('Showing quiz content', ['quiz_id' => $quiz->id, 'best_attempt_id' => $bestAttempt?->id]);

        return view('courses.quiz-content', compact('course', 'quiz', 'bestAttempt'));
    }

    /**
     * Start quiz
     */
    public function start(Request $request, Course $course)
    {
        \Log::info('Quiz start called for course: ' . $course->id);
        
        $user = Auth::user();
        
        if (!$user) {
            \Log::error('User not authenticated');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $quiz = $course->quiz;
        
        if (!$quiz || !$quiz->is_active) {
            \Log::error('Quiz not available or inactive', ['quiz_id' => $quiz?->id, 'is_active' => $quiz?->is_active]);
            return response()->json(['error' => 'Quiz not available'], 404);
        }

        \Log::info('Creating quiz attempt', ['quiz_id' => $quiz->id, 'user_id' => $user->id, 'max_score' => $quiz->getMaxScore()]);

        // Create new attempt
        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'started_at' => now(),
            'max_score' => $quiz->getMaxScore(),
        ]);

        $redirectUrl = route('quizzes.take', ['course' => $course, 'attempt' => $attempt]);
        \Log::info('Quiz attempt created', ['attempt_id' => $attempt->id, 'redirect_url' => $redirectUrl]);

        return response()->json([
            'success' => true,
            'attempt_id' => $attempt->id,
            'redirect_url' => $redirectUrl
        ]);
    }

    /**
     * Take quiz
     */
    public function take(Course $course, QuizAttempt $attempt)
    {
        \Log::info('Quiz take called', ['course_id' => $course->id, 'attempt_id' => $attempt->id]);
        
        $user = Auth::user();
        
        if (!$user || $attempt->user_id !== $user->id) {
            \Log::error('User mismatch or unauthorized', ['user_id' => $user?->id, 'attempt_user_id' => $attempt->user_id]);
            return redirect()->route('courses.show', $course);
        }

        if ($attempt->completed_at) {
            \Log::info('Attempt already completed, redirecting to result', ['completed_at' => $attempt->completed_at]);
            return redirect()->route('quizzes.result', ['course' => $course, 'attempt' => $attempt]);
        }

        $quiz = $attempt->quiz;
        $questions = $quiz->questions;
        
        \Log::info('Showing quiz take view', ['quiz_id' => $quiz->id, 'questions_count' => $questions->count()]);

        return view('quizzes.take', compact('course', 'quiz', 'attempt', 'questions'));
    }

    /**
     * Load quiz questions for AJAX (similar to lesson content)
     */
    public function loadQuestions(Course $course, QuizAttempt $attempt)
    {
        \Log::info('Quiz loadQuestions called', ['course_id' => $course->id, 'attempt_id' => $attempt->id]);
        
        $user = Auth::user();
        
        if (!$user || $attempt->user_id !== $user->id) {
            \Log::error('User mismatch or unauthorized in loadQuestions', ['user_id' => $user?->id, 'attempt_user_id' => $attempt->user_id]);
            return response('Unauthorized', 401);
        }

        if ($attempt->completed_at) {
            \Log::info('Attempt already completed in loadQuestions', ['completed_at' => $attempt->completed_at]);
            return response()->view('courses.quiz-content', [
                'info' => 'Test został już ukończony.',
                'course' => $course,
                'quiz' => $attempt->quiz,
                'bestAttempt' => $attempt
            ]);
        }

        $quiz = $attempt->quiz;
        $questions = $quiz->questions;
        
        \Log::info('Loading quiz questions via AJAX', ['quiz_id' => $quiz->id, 'questions_count' => $questions->count()]);

        return view('courses.quiz-questions', compact('course', 'quiz', 'attempt', 'questions'));
    }

    /**
     * Submit quiz
     */
    public function submit(Request $request, Course $course, QuizAttempt $attempt)
    {
        $user = Auth::user();
        
        if (!$user || $attempt->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($attempt->completed_at) {
            return response()->json(['error' => 'Quiz already completed'], 400);
        }

        $answers = $request->input('answers', []);
        
        // Update attempt with answers and completion
        $attempt->update([
            'answers' => $answers,
            'completed_at' => now(),
        ]);

        // Calculate results
        $attempt->calculateScore();
        $percentage = $attempt->calculatePercentage();
        $attempt->percentage = $percentage;
        $attempt->passed = $percentage >= $attempt->quiz->passing_score;
        $attempt->applyScoreMultiplier(); // This now calculates earned points based on course
        
        $attempt->save();

        // Check if request is AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('quizzes.result', ['course' => $course, 'attempt' => $attempt])
            ]);
        }
        
        // Regular form submission - redirect
        return redirect()->route('quizzes.result', ['course' => $course, 'attempt' => $attempt]);
    }

    /**
     * Show quiz result
     */
    public function result(Course $course, QuizAttempt $attempt)
    {
        $user = Auth::user();
        
        if (!$user || $attempt->user_id !== $user->id) {
            return redirect()->route('courses.show', $course);
        }

        if (!$attempt->completed_at) {
            return redirect()->route('quizzes.take', ['course' => $course, 'attempt' => $attempt]);
        }

        return view('quizzes.result', compact('course', 'attempt'));
    }
}
