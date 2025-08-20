<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Show course details
     */
    public function show(Course $course)
    {
        $user = auth()->user();
        
        if ($user) {
            // Auto-complete expired timer lessons
            $course->lessons->each(function($lesson) use ($user) {
                $lesson->checkAndCompleteIfTimerExpired($user);
            });
            
            $chapters = $course->chapters()->with(['lessons' => function($query) use ($user) {
                $query->orderBy('order')->with(['instructor', 'userProgress' => function($q) use ($user) {
                    $q->where('user_id', $user->id);
                }]);
            }])->orderBy('order')->get();
        } else {
            $chapters = $course->chapters()->with(['lessons' => function($query) {
                $query->orderBy('order')->with(['instructor']);
            }])->orderBy('order')->get();
        }

        // If no chapters exist, get all lessons directly
        if ($chapters->isEmpty()) {
            if ($user) {
                $lessons = $course->lessons()->with(['instructor', 'userProgress' => function($q) use ($user) {
                    $q->where('user_id', $user->id);
                }])->orderBy('order')->get();
            } else {
                $lessons = $course->lessons()->with(['instructor'])->orderBy('order')->get();
            }
            $chapters = collect(); // Empty collection for chapters
        } else {
            // When chapters exist, still get lessons for fallback display
            if ($user) {
                $lessons = $course->lessons()->with(['instructor', 'userProgress' => function($q) use ($user) {
                    $q->where('user_id', $user->id);
                }])->orderBy('order')->get();
            } else {
                $lessons = $course->lessons()->with(['instructor'])->orderBy('order')->get();
            }
        }

        // Calculate progress
        $totalLessons = $course->lessons()->count();
        $completedLessons = 0;
        if ($user) {
            $completedLessons = $course->lessons()
                ->whereHas('userProgress', function($query) use ($user) {
                    $query->where('user_id', $user->id)->where('is_completed', true);
                })->count();
        }
        $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        // Get quiz information
        $quiz = $course->quiz;
        $quizAttempt = null;
        $canTakeQuiz = false;
        
        if ($user && $quiz && $quiz->is_active) {
            $quiz->load('questions');
            $quizAttempt = $quiz->getUserBestAttempt($user);
            $canTakeQuiz = $course->canUserAccessQuiz($user) && !$quiz->hasUserPassed($user);
        }

        // Get first available lesson for auto-start
        $firstAvailableLesson = null;
        if ($user) {
            $firstAvailableLesson = $course->lessons()
                ->orderBy('order')
                ->get()
                ->first(function($lesson) use ($user) {
                    return $lesson->isAccessibleByUser($user);
                });
        }

        return view('courses.show', compact('course', 'chapters', 'lessons', 'totalLessons', 'completedLessons', 'progressPercentage', 'quiz', 'quizAttempt', 'canTakeQuiz', 'firstAvailableLesson'));
    }

    /**
     * Show lesson
     */
    public function lesson(Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if lesson is accessible
        if (!$lesson->isAccessibleByUser($user)) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'Ta lekcja nie jest jeszcze dostępna.');
        }

        $nextLesson = $lesson->nextLesson();
        $previousLesson = $lesson->previousLesson();
        
        $userProgress = UserProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        return view('courses.lesson', compact('course', 'lesson', 'nextLesson', 'previousLesson', 'userProgress'));
    }

    /**
     * Mark lesson as completed
     */
    public function completeLesson(Request $request, Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $lesson->markAsCompleted($user);

        // Check if course is now completed and quiz should be unlocked
        $quizUnlocked = false;
        $quiz = $course->quiz;
        if ($quiz && $quiz->is_active && $course->canUserAccessQuiz($user) && !$quiz->hasUserPassed($user)) {
            $quizUnlocked = true;
        }

        return response()->json([
            'success' => true,
            'message' => 'Lekcja została ukończona.',
            'quiz_unlocked' => $quizUnlocked,
            'course_completed' => $course->isCompletedByUser($user)
        ]);
    }

    /**
     * Download lesson file
     */
    public function downloadFile(Request $request, Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user can access materials
        if (!$course->canUserAccessMaterials($user)) {
            return back()->with('error', 'Materiały do pobrania są zablokowane. Ukończ wszystkie lekcje aby je odblokować.');
        }

        // Handle POST request for marking file as downloaded
        if ($request->isMethod('post')) {
            $lesson->markFileAsDownloaded($user);
            return response()->json(['success' => true]);
        }

        // Handle file download
        if ($lesson->hasDownloadableMaterials()) {
            $materials = $lesson->downloadable_materials;
            $fileName = $request->get('file');
            
            if ($fileName && is_array($materials)) {
                foreach ($materials as $material) {
                    if (isset($material['name']) && $material['name'] === $fileName && isset($material['file'])) {
                        $filePath = storage_path('app/public/' . $material['file']);
                        if (file_exists($filePath)) {
                            // Mark file as downloaded
                            $lesson->markFileAsDownloaded($user);
                            return response()->download($filePath, $fileName);
                        }
                    }
                }
            }
            
            // Fallback: return first available material
            if (!empty($materials) && isset($materials[0]['file'])) {
                $filePath = storage_path('app/public/' . $materials[0]['file']);
                if (file_exists($filePath)) {
                    // Mark file as downloaded
                    $lesson->markFileAsDownloaded($user);
                    return response()->download($filePath, $materials[0]['name'] ?? 'download');
                }
            }
        }

        // Legacy support for old file_path attribute
        if ($lesson->file_path && file_exists(storage_path('app/public/' . $lesson->file_path))) {
            // Mark file as downloaded
            $lesson->markFileAsDownloaded($user);
            return response()->download(storage_path('app/public/' . $lesson->file_path));
        }

        // If no real materials exist, generate a demo PDF
        $demoContent = "Materiały szkoleniowe - " . $lesson->title . "\n\n" . 
                      "To jest przykładowy plik demonstracyjny.\n" .
                      "W rzeczywistej implementacji tutaj znajdowałyby się prawdziwe materiały szkoleniowe.\n\n" .
                      "Pobrano: " . now()->format('d.m.Y H:i:s');
        
        $fileName = 'materialy-' . \Str::slug($lesson->title) . '.txt';
        
        // Mark file as downloaded
        $lesson->markFileAsDownloaded($user);
        
        return response($demoContent)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    /**
     * Show course progress
     */
    public function progress(Course $course)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $lessons = $course->lessons;
        $progress = $course->userProgress()
            ->where('user_id', $user->id)
            ->get()
            ->keyBy('lesson_id');
        
        $completionPercentage = $course->getCompletionPercentage($user);
        $isCompleted = $course->isCompletedByUser($user);

        return view('courses.progress', compact('course', 'lessons', 'progress', 'completionPercentage', 'isCompleted'));
    }

    /**
     * Save video position
     */
    public function saveVideoPosition(Request $request, Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'position' => 'required|integer|min:0',
        ]);

        $userProgress = UserProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$userProgress) {
            $userProgress = UserProgress::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'lesson_id' => $lesson->id,
                'video_position' => $validated['position'],
            ]);
        } else {
            $userProgress->update(['video_position' => $validated['position']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Download lesson video
     */
    public function downloadVideo(Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if (!$lesson->video_file) {
            return back()->with('error', 'Plik wideo nie istnieje.');
        }

        $filePath = storage_path('app/public/' . $lesson->video_file);
        if (!file_exists($filePath)) {
            return back()->with('error', 'Plik wideo nie został znaleziony.');
        }

        return response()->download($filePath);
    }

    public function loadLesson(Course $course, Lesson $lesson)
    {
        $user = auth()->user();
        $userProgress = null;
        
        if ($user) {
            // Check if any download timer has expired and auto-complete lesson
            $lesson->checkAndCompleteIfTimerExpired($user);
            
            $userProgress = $lesson->userProgress()->where('user_id', $user->id)->first();
        }

        // Check if user can access materials
        $canAccessMaterials = false;
        if ($user) {
            $canAccessMaterials = $course->canUserAccessMaterials($user);
        }

        return view('courses.lesson-content', compact('course', 'lesson', 'userProgress', 'canAccessMaterials'));
    }

    /**
     * Get navigation info for current lesson
     */
    public function getLessonNavigation(Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $nextLesson = $lesson->nextLesson();
            $previousLesson = $lesson->previousLesson();

            return response()->json([
                'success' => true,
                'current_lesson' => [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'is_completed' => $lesson->isCompletedByUser($user)
                ],
                'next_lesson' => $nextLesson ? [
                    'id' => $nextLesson->id,
                    'title' => $nextLesson->title,
                    'is_accessible' => $nextLesson->isAccessibleByUser($user),
                    'url' => route('courses.lesson', ['course' => $course, 'lesson' => $nextLesson])
                ] : null,
                'previous_lesson' => $previousLesson ? [
                    'id' => $previousLesson->id,
                    'title' => $previousLesson->title,
                    'is_accessible' => $previousLesson->isAccessibleByUser($user),
                    'url' => route('courses.lesson', ['course' => $course, 'lesson' => $previousLesson])
                ] : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Wystąpił błąd podczas pobierania nawigacji: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get lessons status for AJAX updates
     */
    public function getLessonsStatus(Course $course)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            // Get all lessons with their progress
            $lessons = $course->lessons()->with(['userProgress' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])->orderBy('order')->get();

            $lessonsData = $lessons->map(function($lesson) use ($user) {
                return [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'is_completed' => $lesson->isCompletedByUser($user),
                    'is_accessible' => $lesson->isAccessibleByUser($user)
                ];
            });

            // Calculate progress
            $totalLessons = $lessons->count();
            $completedLessons = $lessons->filter(function($lesson) use ($user) {
                return $lesson->isCompletedByUser($user);
            })->count();
            $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

            return response()->json([
                'success' => true,
                'lessons' => $lessonsData,
                'progress_percentage' => $progressPercentage,
                'completed_lessons' => $completedLessons,
                'total_lessons' => $totalLessons
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Wystąpił błąd podczas pobierania statusu lekcji: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset course progress for testing purposes
     */
    public function resetProgress(Request $request, Course $course)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Reset progress is now available for testing purposes on all environments

        try {
            // Delete all user progress for this course
            UserProgress::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->delete();

            // Also delete quiz attempts for this course
            if ($course->quiz) {
                $course->quiz->attempts()
                    ->where('user_id', $user->id)
                    ->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Postępy w kursie oraz wyniki testów zostały usunięte.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Wystąpił błąd podczas resetowania postępów: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enroll user in course
     */
    public function enroll(Request $request, Course $course)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user already has progress in this course
        if ($user->hasStartedCourse($course)) {
            return redirect()->route('courses.show', $course)
                ->with('info', 'Już jesteś zapisany do tego kursu.');
        }

        // Create initial progress for first lesson to "enroll" user
        $firstLesson = $course->lessons()->orderBy('order')->first();
        
        if ($firstLesson) {
            UserProgress::create([
                'user_id' => $user->id,
                'lesson_id' => $firstLesson->id,
                'course_id' => $course->id,
                'is_completed' => false,
                'completed_at' => null
            ]);
        }

        return redirect()->route('courses.show', $course)
            ->with('success', 'Pomyślnie dołączyłeś do szkolenia!');
    }
}
