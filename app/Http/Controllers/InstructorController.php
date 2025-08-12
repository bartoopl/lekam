<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    /**
     * Display a listing of instructors
     */
    public function index()
    {
        $instructors = Instructor::with('lessons')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.instructors.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new instructor
     */
    public function create()
    {
        return view('admin.instructors.create');
    }

    /**
     * Store a newly created instructor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email',
            'bio' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('instructors', 'public');
            $validated['photo'] = $path;
        }

        // Handle boolean field
        $validated['is_active'] = $request->has('is_active');

        Instructor::create($validated);

        return redirect()->route('admin.instructors.index')
            ->with('success', 'Wykładowca został utworzony pomyślnie.');
    }

    /**
     * Display the specified instructor
     */
    public function show(Instructor $instructor)
    {
        $instructor->load(['lessons.course']);
        
        return view('admin.instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified instructor
     */
    public function edit(Instructor $instructor)
    {
        return view('admin.instructors.edit', compact('instructor'));
    }

    /**
     * Update the specified instructor
     */
    public function update(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email,' . $instructor->id,
            'bio' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($instructor->photo) {
                Storage::disk('public')->delete($instructor->photo);
            }
            
            $path = $request->file('photo')->store('instructors', 'public');
            $validated['photo'] = $path;
        }

        // Handle boolean field
        $validated['is_active'] = $request->has('is_active');

        $instructor->update($validated);

        return redirect()->route('admin.instructors.show', $instructor)
            ->with('success', 'Wykładowca został zaktualizowany pomyślnie.');
    }

    /**
     * Remove the specified instructor
     */
    public function destroy(Instructor $instructor)
    {
        // Delete photo if exists
        if ($instructor->photo) {
            Storage::disk('public')->delete($instructor->photo);
        }

        $instructor->delete();

        return redirect()->route('admin.instructors.index')
            ->with('success', 'Wykładowca został usunięty pomyślnie.');
    }
}
