<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\UserProgress;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Certificate;
use App\Models\Representative;
use App\Models\Content;
use App\Models\CertificateSendLog;
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
     * Export users to CSV with consent status
     */
    public function usersExport()
    {
        // Debug: Write to file to confirm method is called
        file_put_contents(storage_path('logs/export_debug.txt'), date('Y-m-d H:i:s') . " - usersExport called\n", FILE_APPEND);
        
        error_log('=== usersExport METHOD CALLED ===');
        \Log::info('usersExport called - generating CSV with representative columns');
        
        $users = User::with(['certificates' => function($query) {
            $query->orderBy('issued_at', 'desc');
        }, 'representative'])->get();
        
        error_log('=== usersExport: Loaded ' . $users->count() . ' users ===');

        $filename = 'uzytkownicy_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
            'Expires' => '0',
            'Last-Modified' => gmdate('D, d M Y H:i:s') . ' GMT',
        ];

        $callback = function() use ($users) {
            // Debug: Confirm closure is executed
            file_put_contents(storage_path('logs/export_debug.txt'), date('Y-m-d H:i:s') . " - Closure executed, users count: " . $users->count() . "\n", FILE_APPEND);
            
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            $csvHeaders = [
                'ID',
                'Imię i Nazwisko',
                'Email',
                'Telefon',
                'Typ użytkownika',
                'Numer PWZ',
                'Adres apteki',
                'Kod pocztowy apteki',
                'Miasto apteki użytkownika',
                'Data rejestracji',
                'Ostatnia aktywność',
                'Liczba certyfikatów',
                'Ostatni certyfikat',
                'Email zweryfikowany',
                'Administrator',
                'Zgoda 1 (RODO - wymagana)',
                'Zgoda 2 (Marketing LEK-AM)',
                'Zgoda 3 (Marketing NeoArt)',
                'ID Przedstawiciela',
                'Nazwa Przedstawiciela',
                'Email Przedstawiciela',
                'Kod Przedstawiciela'
            ];
            // Debug: Write headers info to file
            file_put_contents(storage_path('logs/export_debug.txt'), date('Y-m-d H:i:s') . " - CSV Headers count: " . count($csvHeaders) . ", Last: " . end($csvHeaders) . "\n", FILE_APPEND);
            file_put_contents(storage_path('logs/export_debug.txt'), date('Y-m-d H:i:s') . " - All headers: " . implode(', ', $csvHeaders) . "\n", FILE_APPEND);
            
            error_log('=== CSV EXPORT: Headers count: ' . count($csvHeaders) . ', Last header: ' . end($csvHeaders) . ' ===');
            \Log::info('CSV EXPORT: Headers count: ' . count($csvHeaders) . ', Last header: ' . end($csvHeaders));
            \Log::info('CSV EXPORT: All headers: ' . implode(', ', $csvHeaders));
            fputcsv($file, $csvHeaders, ';');
            error_log('=== CSV EXPORT: Headers written to file ===');

            // Data rows
            foreach ($users as $user) {
                // Get last certificate info
                $lastCertificate = $user->certificates->first();
                $certificateCount = $user->certificates->count();
                $lastCertificateDate = $lastCertificate ? $lastCertificate->issued_at->format('Y-m-d H:i:s') : '';

                // Get last activity - fallback to updated_at if no better indicator
                $lastActivity = $user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : '';

                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone ?? '',
                    $user->user_type === 'farmaceuta' ? 'Farmaceuta' : 'Technik farmacji',
                    $user->pwz_number ?? '',
                    $user->pharmacy_address ?? '',
                    $user->pharmacy_postal_code ?? '',
                    $user->pharmacy_city ?? '',
                    $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '',
                    $lastActivity,
                    $certificateCount,
                    $lastCertificateDate,
                    $user->email_verified_at ? 'Tak' : 'Nie',
                    $user->is_admin ? 'Tak' : 'Nie',
                    $user->consent_1 ? 'Tak' : 'Nie',
                    $user->consent_2 ? 'Tak' : 'Nie',
                    $user->consent_3 ? 'Tak' : 'Nie',
                    $user->representative_id ?? '',
                    $user->representative ? $user->representative->name : '',
                    $user->representative ? ($user->representative->email ?? '') : '',
                    $user->representative ? ($user->representative->code ?? '') : '',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show user edit form
     */
    public function userEdit(User $user)
    {
        $representatives = \App\Models\Representative::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.users.edit', compact('user', 'representatives'));
    }

    /**
     * Update user information
     */
    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'user_type' => 'required|in:farmaceuta,technik_farmacji',
            'is_admin' => 'boolean',
            'representative_id' => 'nullable|exists:representatives,id',
        ]);

        // Prevent the current admin from removing their own admin privileges
        if ($user->id === auth()->id() && !$request->has('is_admin')) {
            return redirect()->back()->with('error', 'Nie możesz usunąć własnych uprawnień administratora.');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'is_admin' => $request->has('is_admin'),
            'representative_id' => $request->representative_id,
        ]);

        return redirect()->route('admin.users')->with('success', 'Użytkownik został zaktualizowany pomyślnie.');
    }

    /**
     * Delete user
     */
    public function userDestroy(User $user)
    {
        // Prevent the current admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Nie możesz usunąć własnego konta.');
        }

        // Store user name for success message
        $userName = $user->name;

        // Delete user (cascade deletes will handle related records)
        $user->delete();

        return redirect()->route('admin.users')->with('success', "Użytkownik {$userName} został usunięty pomyślnie.");
    }

    /**
     * Show user progress in courses
     */
    public function userProgress(User $user)
    {
        // Get user progress with course and lesson information
        $userProgress = UserProgress::with(['course', 'lesson'])
            ->where('user_id', $user->id)
            ->get()
            ->groupBy('course_id');

        // Get all available courses
        $courses = Course::with(['lessons', 'quiz'])
            ->orderBy('title')
            ->get();

        // Get user certificates
        $certificates = Certificate::with('course')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate overall progress stats
        $totalCourses = $courses->count();
        $completedCourses = $certificates->where('is_valid', true)->count();
        $inProgressCourses = $userProgress->filter(function($progress) {
            return $progress->contains(function($item) {
                return $item->is_completed;
            });
        })->count();

        return view('admin.users.progress', compact(
            'user',
            'userProgress',
            'courses',
            'certificates',
            'totalCourses',
            'completedCourses',
            'inProgressCourses'
        ));
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
            'order' => 'nullable|integer|min:0',
            'pharmacist_points' => 'required|integer|min:0',
            'technician_points' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'requires_sequential_lessons' => 'nullable|boolean',
            'certificate_header' => 'nullable|string',
            'certificate_footer' => 'nullable|string',
            'has_instruction' => 'nullable|boolean',
            'instruction_content' => 'nullable|string',
        ]);

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['requires_sequential_lessons'] = $request->has('requires_sequential_lessons');
        $validated['has_instruction'] = $request->has('has_instruction');

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
            'order' => 'nullable|integer|min:0',
            'pharmacist_points' => 'required|integer|min:0',
            'technician_points' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'requires_sequential_lessons' => 'nullable|boolean',
            'certificate_header' => 'nullable|string',
            'certificate_footer' => 'nullable|string',
            'has_instruction' => 'nullable|boolean',
            'instruction_content' => 'nullable|string',
        ]);

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['requires_sequential_lessons'] = $request->has('requires_sequential_lessons');
        $validated['has_instruction'] = $request->has('has_instruction');

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
            'questions_to_draw' => 'nullable|integer|min:1',
            'min_correct_answers' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['course_id'] = $course->id;
        $validated['is_active'] = $request->has('is_active');

        // Ensure nullable fields are actually null, not empty strings
        $validated['description'] = $validated['description'] ?? null;
        $validated['questions_to_draw'] = !empty($validated['questions_to_draw']) ? $validated['questions_to_draw'] : null;
        $validated['min_correct_answers'] = !empty($validated['min_correct_answers']) ? $validated['min_correct_answers'] : null;

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
            'questions_to_draw' => 'nullable|integer|min:1',
            'min_correct_answers' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Ensure nullable fields are actually null, not empty strings
        $validated['description'] = $validated['description'] ?? null;
        $validated['questions_to_draw'] = !empty($validated['questions_to_draw']) ? $validated['questions_to_draw'] : null;
        $validated['min_correct_answers'] = !empty($validated['min_correct_answers']) ? $validated['min_correct_answers'] : null;

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
     * Show logs of certificates sent for signing
     */
    public function certificateSendLogs()
    {
        $logs = CertificateSendLog::with(['certificate.user', 'certificate.course'])
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        return view('admin.certificates-send-logs', compact('logs'));
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

    /**
     * Show content management
     */
    public function contentIndex()
    {
        $pageInfo = Content::getPageInfo();
        $contentStats = [];

        foreach ($pageInfo as $page => $info) {
            $contentStats[$page] = [
                'info' => $info,
                'count' => Content::where('page', $page)->count(),
                'active' => Content::where('page', $page)->where('is_active', true)->count()
            ];
        }

        return view('admin.content.index', compact('contentStats'));
    }

    /**
     * Show page content edit form
     */
    public function contentPageEdit($page)
    {
        $pageInfo = Content::getPageInfo();

        if (!array_key_exists($page, $pageInfo)) {
            abort(404);
        }

        $contents = Content::where('page', $page)->orderBy('section')->get();

        return view('admin.content.page-edit', compact('page', 'pageInfo', 'contents'));
    }

    /**
     * Update page content
     */
    public function contentPageUpdate(Request $request, $page)
    {
        $pageInfo = Content::getPageInfo();

        if (!array_key_exists($page, $pageInfo)) {
            abort(404);
        }

        $contents = $request->input('contents', []);

        foreach ($contents as $contentId => $data) {
            $content = Content::find($contentId);
            if ($content && $content->page === $page) {
                $request->validate([
                    "contents.{$contentId}.content" => 'required|string',
                ]);

                $content->update([
                    'content' => $data['content'],
                    'is_active' => isset($data['is_active']) ? true : false,
                ]);
            }
        }

        return redirect()->route('admin.content.index')
            ->with('success', 'Treści strony zostały zaktualizowane pomyślnie.');
    }

    /**
     * Show content edit form (pojedyncza treść)
     */
    public function contentEdit(Content $content)
    {
        return view('admin.content.edit', compact('content'));
    }

    /**
     * Update content (pojedyncza treść)
     */
    public function contentUpdate(Request $request, Content $content)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $content->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.content.index')
            ->with('success', 'Treść została zaktualizowana pomyślnie.');
    }
}
