<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Representative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepresentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $representatives = Representative::withCount('users')->paginate(15);
        return view('admin.representatives.index', compact('representatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.representatives.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:representatives,email',
            'phone' => 'nullable|string|max:20',
        ]);

        $representative = Representative::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'code' => Representative::generateCode(),
            'is_active' => true,
        ]);

        return redirect()->route('admin.representatives.show', $representative)
                        ->with('success', 'Przedstawiciel został utworzony.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Representative $representative)
    {
        $representative->load([
            'users' => function($query) {
                $query->latest()->limit(10)->with(['certificates.course']);
            }
        ]);

        // Get course completion statistics for this representative's users
        $userIds = $representative->users()->pluck('id');
        $courseStats = collect();

        if ($userIds->isNotEmpty()) {
            $courseStats = DB::table('certificates')
                ->join('courses', 'certificates.course_id', '=', 'courses.id')
                ->join('users', 'certificates.user_id', '=', 'users.id')
                ->whereIn('certificates.user_id', $userIds)
                ->where('certificates.is_valid', true)
                ->select('courses.title', 'courses.id', DB::raw('COUNT(*) as completions'))
                ->groupBy('courses.id', 'courses.title')
                ->orderBy('completions', 'desc')
                ->get()
                ->map(function ($stat) use ($userIds) {
                    // Get user names for this course
                    $userNames = DB::table('certificates')
                        ->join('users', 'certificates.user_id', '=', 'users.id')
                        ->where('certificates.course_id', $stat->id)
                        ->whereIn('certificates.user_id', $userIds)
                        ->where('certificates.is_valid', true)
                        ->pluck('users.name')
                        ->implode(', ');

                    $stat->user_names = $userNames;
                    return $stat;
                });
        }

        return view('admin.representatives.show', compact('representative', 'courseStats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Representative $representative)
    {
        return view('admin.representatives.edit', compact('representative'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Representative $representative)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:representatives,email,' . $representative->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $representative->update($request->only(['name', 'email', 'phone', 'is_active']));

        return redirect()->route('admin.representatives.show', $representative)
                        ->with('success', 'Przedstawiciel został zaktualizowany.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Representative $representative)
    {
        $representative->delete();
        
        return redirect()->route('admin.representatives.index')
                        ->with('success', 'Przedstawiciel został usunięty.');
    }

    /**
     * Generate new code for representative
     */
    public function generateNewCode(Representative $representative)
    {
        $representative->update([
            'code' => Representative::generateCode(),
        ]);

        return redirect()->route('admin.representatives.show', $representative)
                        ->with('success', 'Nowy kod został wygenerowany.');
    }
}
