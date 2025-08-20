<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Certificate;
use App\Models\Representative;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_courses' => Course::count(),
            'total_lessons' => Lesson::count(),
            'total_certificates' => Certificate::count(),
            'active_courses' => Course::where('is_active', true)->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_courses' => Course::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show users management
     */
    public function users()
    {
        $users = User::with('certificates')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Show courses management
     */
    public function courses()
    {
        $courses = Course::with('lessons', 'quiz')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.courses', compact('courses'));
    }

    /**
     * Show course details in admin
     */
    public function courseShow(Course $course)
    {
        $course->load(['lessons', 'quiz', 'certificates']);
        
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show create course form
     */
    public function courseCreate()
    {
        return view('admin.courses.create');
    }

    /**
     * Store new course
     */
    public function courseStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration_minutes' => 'required|integer|min:1',
            'pharmacist_points' => 'required|integer|min:0',
            'technician_points' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'requires_sequential_lessons' => 'nullable|boolean',
            'certificate_header' => 'nullable|string',
            'certificate_footer' => 'nullable|string',
        ]);

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['requires_sequential_lessons'] = $request->has('requires_sequential_lessons');

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses/thumbnails', 'public');
            $validated['image'] = $imagePath;
        }

        Course::create($validated);

        return redirect()->route('admin.courses')
            ->with('success', 'Kurs został utworzony pomyślnie.');
    }

    /**
     * Show edit course form
     */
    public function courseEdit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update course
     */
    public function courseUpdate(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration_minutes' => 'required|integer|min:1',
            'pharmacist_points' => 'required|integer|min:0',
            'technician_points' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'requires_sequential_lessons' => 'nullable|boolean',
            'certificate_header' => 'nullable|string',
            'certificate_footer' => 'nullable|string',
        ]);

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['requires_sequential_lessons'] = $request->has('requires_sequential_lessons');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image && file_exists(storage_path('app/public/' . $course->image))) {
                unlink(storage_path('app/public/' . $course->image));
            }
            
            $imagePath = $request->file('image')->store('courses/thumbnails', 'public');
            $validated['image'] = $imagePath;
        }

        $course->update($validated);

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Kurs został zaktualizowany pomyślnie.');
    }

    /**
     * Delete course
     */
    public function courseDestroy(Course $course)
    {
        // Delete course image if exists
        if ($course->image && file_exists(storage_path('app/public/' . $course->image))) {
            unlink(storage_path('app/public/' . $course->image));
        }

        $course->delete();

        return redirect()->route('admin.courses')
            ->with('success', 'Kurs został usunięty pomyślnie.');
    }

    /**
     * Remove course image
     */
    public function removeCourseImage(Course $course)
    {
        if ($course->image && file_exists(storage_path('app/public/' . $course->image))) {
            unlink(storage_path('app/public/' . $course->image));
            $course->update(['image' => null]);
            
            return response()->json(['success' => true, 'message' => 'Obrazek został usunięty.']);
        }
        
        return response()->json(['success' => false, 'message' => 'Obrazek nie istnieje.'], 404);
    }

    /**
     * Show create quiz form
     */
    public function quizCreate(Course $course)
    {
        return view('admin.quizzes.create', compact('course'));
    }

    /**
     * Store new quiz
     */
    public function quizStore(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:1|max:480',
            'passing_score' => 'required|integer|min:1|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['course_id'] = $course->id;
        $validated['is_active'] = $request->has('is_active');

        $quiz = Quiz::create($validated);

        return redirect()->route('admin.quizzes.edit', [$course, $quiz])
            ->with('success', 'Test został utworzony pomyślnie. Teraz dodaj pytania.');
    }

    /**
     * Show edit quiz form
     */
    public function quizEdit(Course $course, Quiz $quiz)
    {
        if ($quiz->course_id !== $course->id) {
            abort(404);
        }

        return view('admin.quizzes.edit', compact('course', 'quiz'));
    }

    /**
     * Update quiz
     */
    public function quizUpdate(Request $request, Course $course, Quiz $quiz)
    {
        if ($quiz->course_id !== $course->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:1|max:480',
            'passing_score' => 'required|integer|min:1|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.edit', [$course, $quiz])
            ->with('success', 'Test został zaktualizowany pomyślnie.');
    }

    /**
     * Delete quiz
     */
    public function quizDestroy(Course $course, Quiz $quiz)
    {
        if ($quiz->course_id !== $course->id) {
            abort(404);
        }

        $quiz->delete();

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Test został usunięty pomyślnie.');
    }

    /**
     * Show create question form
     */
    public function questionCreate(Course $course, Quiz $quiz)
    {
        if ($quiz->course_id !== $course->id) {
            abort(404);
        }

        return view('admin.questions.create', compact('course', 'quiz'));
    }

    /**
     * Store new question
     */
    public function questionStore(Request $request, Course $course, Quiz $quiz)
    {
        if ($quiz->course_id !== $course->id) {
            abort(404);
        }

        $validated = $request->validate([
            'question' => 'required|string|max:1000',
            'type' => 'required|in:single_choice,multiple_choice,true_false',
            'options' => 'required_if:type,single_choice,multiple_choice|array|min:2',
            'options.*' => 'required|string|max:255',
            'correct_answers' => 'required|array|min:1',
            'correct_answers.*' => 'required',
            'points' => 'required|integer|min:1|max:100',
            'order' => 'nullable|integer|min:1',
        ]);

        // Validate correct answers based on type
        if ($validated['type'] === 'single_choice') {
            if (count($validated['correct_answers']) !== 1) {
                return back()->withErrors(['correct_answers' => 'Pytanie jednokrotnego wyboru musi mieć dokładnie jedną poprawną odpowiedź.']);
            }
        }

        if ($validated['type'] === 'true_false') {
            $validated['options'] = ['Prawda', 'Fałsz'];
            if (!in_array($validated['correct_answers'][0], [true, false])) {
                return back()->withErrors(['correct_answers' => 'Dla pytania prawda/fałsz wybierz true lub false.']);
            }
        }

        // Set order if not provided
        if (!isset($validated['order'])) {
            $validated['order'] = $quiz->questions()->max('order') + 1;
        }

        $validated['quiz_id'] = $quiz->id;

        QuizQuestion::create($validated);

        return redirect()->route('admin.quizzes.edit', [$course, $quiz])
            ->with('success', 'Pytanie zostało dodane pomyślnie.');
    }

    /**
     * Show edit question form
     */
    public function questionEdit(Course $course, Quiz $quiz, QuizQuestion $question)
    {
        if ($quiz->course_id !== $course->id || $question->quiz_id !== $quiz->id) {
            abort(404);
        }

        return view('admin.questions.edit', compact('course', 'quiz', 'question'));
    }

    /**
     * Update question
     */
    public function questionUpdate(Request $request, Course $course, Quiz $quiz, QuizQuestion $question)
    {
        if ($quiz->course_id !== $course->id || $question->quiz_id !== $quiz->id) {
            abort(404);
        }

        $validated = $request->validate([
            'question' => 'required|string|max:1000',
            'type' => 'required|in:single_choice,multiple_choice,true_false',
            'options' => 'required_if:type,single_choice,multiple_choice|array|min:2',
            'options.*' => 'required|string|max:255',
            'correct_answers' => 'required|array|min:1',
            'correct_answers.*' => 'required',
            'points' => 'required|integer|min:1|max:100',
            'order' => 'nullable|integer|min:1',
        ]);

        // Validate correct answers based on type
        if ($validated['type'] === 'single_choice') {
            if (count($validated['correct_answers']) !== 1) {
                return back()->withErrors(['correct_answers' => 'Pytanie jednokrotnego wyboru musi mieć dokładnie jedną poprawną odpowiedź.']);
            }
        }

        if ($validated['type'] === 'true_false') {
            $validated['options'] = ['Prawda', 'Fałsz'];
            if (!in_array($validated['correct_answers'][0], [true, false])) {
                return back()->withErrors(['correct_answers' => 'Dla pytania prawda/fałsz wybierz true lub false.']);
            }
        }

        $question->update($validated);

        return redirect()->route('admin.quizzes.edit', [$course, $quiz])
            ->with('success', 'Pytanie zostało zaktualizowane pomyślnie.');
    }

    /**
     * Delete question
     */
    public function questionDestroy(Course $course, Quiz $quiz, QuizQuestion $question)
    {
        if ($quiz->course_id !== $course->id || $question->quiz_id !== $quiz->id) {
            abort(404);
        }

        $question->delete();

        return redirect()->route('admin.quizzes.edit', [$course, $quiz])
            ->with('success', 'Pytanie zostało usunięte pomyślnie.');
    }

    /**
     * Show certificates management
     */
    public function certificates()
    {
        $certificates = Certificate::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.certificates', compact('certificates'));
    }

    /**
     * Show statistics
     */
    public function statistics()
    {
        $stats = [
            'users_by_type' => [
                'technik_farmacji' => User::where('user_type', 'technik_farmacji')->count(),
                'farmaceuta' => User::where('user_type', 'farmaceuta')->count(),
            ],
            'courses_by_difficulty' => [
                'podstawowy' => Course::where('difficulty', 'podstawowy')->count(),
                'średni' => Course::where('difficulty', 'średni')->count(),
                'zaawansowany' => Course::where('difficulty', 'zaawansowany')->count(),
            ],
            'recent_activity' => [
                'new_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
                'new_certificates' => Certificate::where('created_at', '>=', now()->subDays(7))->count(),
            ],
            'representatives' => [
                'total' => Representative::count(),
                'active' => Representative::where('is_active', true)->count(),
                'with_registrations' => Representative::has('users')->count(),
                'top_performers' => Representative::withCount('users')
                    ->where('is_active', true)
                    ->orderBy('users_count', 'desc')
                    ->take(5)
                    ->get(),
                'registrations_this_month' => User::whereNotNull('representative_id')
                    ->where('created_at', '>=', now()->startOfMonth())
                    ->count(),
            ],
        ];

        return view('admin.statistics', compact('stats'));
    }
}
