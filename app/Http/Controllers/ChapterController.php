<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Show create chapter form
     */
    public function create(Course $course)
    {
        return view('admin.chapters.create', compact('course'));
    }

    /**
     * Store new chapter
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        $validated['course_id'] = $course->id;

        Chapter::create($validated);

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Sekcja została dodana pomyślnie.');
    }

    /**
     * Show edit chapter form
     */
    public function edit(Course $course, Chapter $chapter)
    {
        return view('admin.chapters.edit', compact('course', 'chapter'));
    }

    /**
     * Update chapter
     */
    public function update(Request $request, Course $course, Chapter $chapter)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        $chapter->update($validated);

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Sekcja została zaktualizowana pomyślnie.');
    }

    /**
     * Delete chapter
     */
    public function destroy(Course $course, Chapter $chapter)
    {
        // Check if chapter has lessons
        if ($chapter->lessons()->count() > 0) {
            return redirect()->route('admin.courses.show', $course)
                ->with('error', 'Nie można usunąć sekcji, która zawiera lekcje. Najpierw usuń wszystkie lekcje.');
        }

        $chapter->delete();

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Sekcja została usunięta pomyślnie.');
    }
}
