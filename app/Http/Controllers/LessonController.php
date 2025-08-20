<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Instructor;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function __construct()
    {
        // Set PHP upload limits
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '100M');
        ini_set('max_execution_time', '300');
        ini_set('memory_limit', '256M');
        ini_set('max_input_time', '300');
    }

    /**
     * Show the form for creating a new lesson
     */
    public function create(Course $course)
    {
        $instructors = Instructor::active()->orderBy('name')->get();
        $nextOrder = $course->lessons()->max('order') + 1;
        
        return view('admin.lessons.create', compact('course', 'instructors', 'nextOrder'));
    }

    /**
     * Store a newly created lesson
     */
    public function store(Request $request, Course $course)
    {
        try {
            // Debug: Log what we're receiving
            \Log::info('Lesson creation request', [
                'has_video_file' => $request->hasFile('video_file'),
                'all_files' => $request->allFiles(),
                'post_data' => $request->except(['video_file']),
            ]);
            
            $validated = $request->validate([
                'chapter_id' => 'required|exists:chapters,id',
                'instructor_id' => 'nullable|exists:instructors,id',
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'video_url' => 'nullable|url',
                // 'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB max - temporarily disabled
                'order' => 'required|integer|min:1',
                'is_required' => 'nullable|boolean',
                'is_first_lesson' => 'nullable|boolean',
                'is_last_lesson' => 'nullable|boolean',
                'requires_download_completion' => 'nullable|boolean',
                'download_timer_minutes' => 'nullable|integer|min:0',
                'downloadable_materials' => 'nullable|array',
                'downloadable_materials.*.name' => 'required_with:downloadable_materials|string|max:255',
                'downloadable_materials.*.file' => 'required_with:downloadable_materials|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt|max:10240',
            ]);

            // Handle boolean fields
            $validated['is_required'] = $request->has('is_required');
            $validated['is_first_lesson'] = $request->has('is_first_lesson');
            $validated['is_last_lesson'] = $request->has('is_last_lesson');
            $validated['requires_download_completion'] = $request->has('requires_download_completion');

            // Handle downloadable materials
            $downloadableMaterials = [];
            // Check all form inputs for debugging
            \Log::info('All request data', [
                'all' => $request->all(),
                'files' => $request->allFiles(),
            ]);
            
            // Process downloadable materials with nested structure
            if ($request->has('downloadable_materials')) {
                $materialInputs = $request->input('downloadable_materials', []);
                foreach ($materialInputs as $index => $materialData) {
                    if (isset($materialData['name']) && $request->hasFile("downloadable_materials.{$index}.file")) {
                        $file = $request->file("downloadable_materials.{$index}.file");
                        if ($file && $file->isValid()) {
                            // Generate unique filename
                            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $path = $file->storeAs('lessons/materials', $filename, 'public');
                            
                            $downloadableMaterials[] = [
                                'name' => $materialData['name'],
                                'file' => $path,
                                'original_name' => $file->getClientOriginalName(),
                                'size' => $file->getSize(),
                                'type' => $file->getMimeType(),
                                'extension' => $file->getClientOriginalExtension(),
                            ];
                            
                            \Log::info('Successfully processed material', [
                                'name' => $materialData['name'],
                                'path' => $path,
                                'size' => $file->getSize()
                            ]);
                        }
                    }
                }
            }
            $validated['downloadable_materials'] = $downloadableMaterials;

            // Handle video file upload
            if ($request->hasFile('video_file')) {
                \Log::info('Video file upload attempt', [
                    'file_exists' => $request->file('video_file')->isValid(),
                    'file_size' => $request->file('video_file')->getSize(),
                    'file_name' => $request->file('video_file')->getClientOriginalName(),
                    'file_mime' => $request->file('video_file')->getMimeType(),
                    'file_extension' => $request->file('video_file')->getClientOriginalExtension(),
                    'upload_error' => $request->file('video_file')->getError(),
                    'upload_error_message' => $request->file('video_file')->getErrorMessage(),
                ]);
                
                if ($request->file('video_file')->isValid()) {
                    try {
                        $videoFile = $request->file('video_file');
                        $filename = time() . '_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();
                        $path = $videoFile->storeAs('lessons/videos', $filename, 'public');
                        $validated['video_file'] = $path;
                        
                        \Log::info('Video file uploaded successfully', ['path' => $path]);
                    } catch (\Exception $e) {
                        \Log::error('Video file storage failed', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                        ]);
                        throw new \Exception('Błąd podczas zapisywania pliku wideo: ' . $e->getMessage());
                    }
                } else {
                    \Log::error('Video file upload failed', [
                        'error' => $request->file('video_file')->getError(),
                        'error_message' => $request->file('video_file')->getErrorMessage(),
                    ]);
                    throw new \Exception('Plik wideo nie został poprawnie załadowany. Błąd: ' . $request->file('video_file')->getErrorMessage());
                }
            }

            $course->lessons()->create($validated);

            return redirect()->route('admin.courses.show', $course)
                ->with('success', 'Lekcja została utworzona pomyślnie.');
                
        } catch (\Exception $e) {
            \Log::error('Lesson creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->withInput()->withErrors(['error' => 'Błąd podczas tworzenia lekcji: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified lesson
     */
    public function edit(Course $course, Lesson $lesson)
    {
        $instructors = Instructor::active()->orderBy('name')->get();
        
        return view('admin.lessons.edit', compact('course', 'lesson', 'instructors'));
    }

    /**
     * Update the specified lesson
     */
    public function update(Request $request, Course $course, Lesson $lesson)
    {
        $validated = $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'instructor_id' => 'nullable|exists:instructors,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB max
            'order' => 'required|integer|min:1',
            'is_required' => 'nullable|boolean',
            'is_first_lesson' => 'nullable|boolean',
            'is_last_lesson' => 'nullable|boolean',
            'requires_download_completion' => 'nullable|boolean',
            'download_timer_minutes' => 'nullable|integer|min:0',
            'downloadable_materials' => 'nullable|array',
            'downloadable_materials.*.name' => 'required_with:downloadable_materials|string|max:255',
            'downloadable_materials.*.file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt|max:10240',
        ]);

        // Handle boolean fields
        $validated['is_required'] = $request->has('is_required');
        $validated['is_first_lesson'] = $request->has('is_first_lesson');
        $validated['is_last_lesson'] = $request->has('is_last_lesson');
        $validated['requires_download_completion'] = $request->has('requires_download_completion');

        // Handle downloadable materials
        $downloadableMaterials = $lesson->downloadable_materials ?? [];
        
        // Check all form inputs for debugging
        \Log::info('Update request data', [
            'all' => $request->all(),
            'files' => $request->allFiles(),
        ]);
        
        // Process new downloadable materials with nested structure
        if ($request->has('downloadable_materials')) {
            $materialInputs = $request->input('downloadable_materials', []);
            foreach ($materialInputs as $index => $materialData) {
                if (isset($materialData['name']) && $request->hasFile("downloadable_materials.{$index}.file")) {
                    $file = $request->file("downloadable_materials.{$index}.file");
                    if ($file && $file->isValid()) {
                        // Generate unique filename
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('lessons/materials', $filename, 'public');
                        
                        $downloadableMaterials[] = [
                            'name' => $materialData['name'],
                            'file' => $path,
                            'original_name' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'type' => $file->getMimeType(),
                            'extension' => $file->getClientOriginalExtension(),
                        ];
                        
                        \Log::info('Successfully processed material in update', [
                            'name' => $materialData['name'],
                            'path' => $path,
                            'size' => $file->getSize()
                        ]);
                    }
                }
            }
        }
        $validated['downloadable_materials'] = $downloadableMaterials;

        // Handle video file upload
        if ($request->hasFile('video_file') && $request->file('video_file')->isValid()) {
            // Delete old video file if exists
            if ($lesson->video_file && Storage::disk('public')->exists($lesson->video_file)) {
                Storage::disk('public')->delete($lesson->video_file);
            }
            
            $videoFile = $request->file('video_file');
            $filename = time() . '_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();
            $path = $videoFile->storeAs('lessons/videos', $filename, 'public');
            $validated['video_file'] = $path;
        }

        $lesson->update($validated);

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Lekcja została zaktualizowana pomyślnie.');
    }

    /**
     * Remove the specified lesson
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        // Delete downloadable materials
        if ($lesson->downloadable_materials) {
            foreach ($lesson->downloadable_materials as $material) {
                if (isset($material['file'])) {
                    Storage::disk('public')->delete($material['file']);
                }
            }
        }

        $lesson->delete();

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Lekcja została usunięta pomyślnie.');
    }

    /**
     * Download a material file
     */
    public function downloadMaterial(Course $course, Lesson $lesson, $materialIndex)
    {
        $materials = $lesson->downloadable_materials;
        
        if (!isset($materials[$materialIndex])) {
            abort(404);
        }

        $material = $materials[$materialIndex];
        $filePath = storage_path('app/public/' . $material['file']);

        if (!file_exists($filePath)) {
            abort(404);
        }

        // Record download progress for timer functionality
        $user = auth()->user();
        if ($user && $lesson->requires_download_completion) {
            $progress = UserProgress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'course_id' => $course->id,
                    'file_downloaded_at' => now(),
                    'can_proceed_after' => $lesson->download_timer_minutes > 0 
                        ? now()->addMinutes($lesson->download_timer_minutes)
                        : now(),
                ]
            );
            
            // If no timer, complete lesson immediately
            if (!$lesson->download_timer_minutes || $lesson->download_timer_minutes <= 0) {
                $lesson->markAsCompleted($user);
            }
        }

        // Use original filename if available, otherwise use the stored name
        $filename = $material['original_name'] ?? $material['name'] . '.' . ($material['extension'] ?? 'pdf');

        return response()->download($filePath, $filename);
    }

    /**
     * Download video file
     */
    public function downloadVideo(Course $course, Lesson $lesson)
    {
        if (!$lesson->video_file) {
            abort(404, 'Plik wideo nie istnieje.');
        }

        if (!Storage::disk('public')->exists($lesson->video_file)) {
            abort(404, 'Plik wideo nie został znaleziony.');
        }

        return Storage::disk('public')->download($lesson->video_file);
    }
}
