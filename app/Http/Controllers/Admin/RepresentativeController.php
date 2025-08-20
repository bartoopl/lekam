<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Representative;
use Illuminate\Http\Request;

class RepresentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $representatives = Representative::withCount('users')->paginate(15);
        return view('representatives.index', compact('representatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('representatives.create');
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

        return redirect()->route('representatives.show', $representative)
                        ->with('success', 'Przedstawiciel został utworzony.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Representative $representative)
    {
        $representative->load(['users' => function($query) {
            $query->latest()->limit(10);
        }]);
        
        return view('representatives.show', compact('representative'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Representative $representative)
    {
        return view('representatives.edit', compact('representative'));
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

        return redirect()->route('representatives.show', $representative)
                        ->with('success', 'Przedstawiciel został zaktualizowany.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Representative $representative)
    {
        $representative->delete();
        
        return redirect()->route('representatives.index')
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

        return redirect()->route('representatives.show', $representative)
                        ->with('success', 'Nowy kod został wygenerowany.');
    }
}
