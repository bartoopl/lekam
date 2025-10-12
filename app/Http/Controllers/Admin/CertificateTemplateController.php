<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateController extends Controller
{
    /**
     * Display a listing of certificate templates
     */
    public function index()
    {
        $templates = CertificateTemplate::with('course')
            ->orderBy('user_type')
            ->orderBy('course_id')
            ->paginate(20);

        return view('admin.certificate-templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new template
     */
    public function create()
    {
        $courses = Course::orderBy('title')->get();
        return view('admin.certificate-templates.create', compact('courses'));
    }

    /**
     * Store a newly created template
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_type' => 'nullable|in:farmaceuta,technik_farmacji',
            'course_id' => 'nullable|exists:courses,id',
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
            'certificate_prefix' => 'required|string|max:20',
            'fields_config' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('certificate_templates', 'public');
            $validated['pdf_path'] = $path;
        }

        // Parse fields_config if provided
        if ($request->has('fields_config') && $request->fields_config) {
            $validated['fields_config'] = json_decode($request->fields_config, true);
        }

        $validated['is_active'] = $request->has('is_active');

        CertificateTemplate::create($validated);

        return redirect()->route('admin.certificate-templates.index')
            ->with('success', 'Szablon certyfikatu został utworzony pomyślnie.');
    }

    /**
     * Show the form for editing the specified template
     */
    public function edit(CertificateTemplate $template)
    {
        $courses = Course::orderBy('title')->get();
        return view('admin.certificate-templates.edit', compact('template', 'courses'));
    }

    /**
     * Update the specified template
     */
    public function update(Request $request, CertificateTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_type' => 'nullable|in:farmaceuta,technik_farmacji',
            'course_id' => 'nullable|exists:courses,id',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'certificate_prefix' => 'required|string|max:20',
            'next_certificate_number' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF
            if ($template->pdf_path && Storage::disk('public')->exists($template->pdf_path)) {
                Storage::disk('public')->delete($template->pdf_path);
            }

            $path = $request->file('pdf_file')->store('certificate_templates', 'public');
            $validated['pdf_path'] = $path;
        }

        // Handle individual field updates
        $fieldsConfig = $template->fields_config ?? [];

        foreach (['certificate_number', 'user_name', 'course_title', 'completion_date', 'points', 'user_type', 'expiry_date'] as $field) {
            if ($request->has("{$field}_x") && $request->has("{$field}_y")) {
                $fieldsConfig[$field] = [
                    'x' => (float) $request->input("{$field}_x"),
                    'y' => (float) $request->input("{$field}_y"),
                    'font_size' => (int) $request->input("{$field}_font_size", 12),
                    'align' => $request->input("{$field}_align", 'left'),
                ];

                if ($request->has("{$field}_width")) {
                    $fieldsConfig[$field]['width'] = (float) $request->input("{$field}_width");
                }
            }
        }

        $validated['fields_config'] = $fieldsConfig;
        $validated['is_active'] = $request->has('is_active');

        $template->update($validated);

        return redirect()->route('admin.certificate-templates.index')
            ->with('success', 'Szablon certyfikatu został zaktualizowany pomyślnie.');
    }

    /**
     * Remove the specified template
     */
    public function destroy(CertificateTemplate $template)
    {
        // Delete PDF file
        if ($template->pdf_path && Storage::disk('public')->exists($template->pdf_path)) {
            Storage::disk('public')->delete($template->pdf_path);
        }

        $template->delete();

        return redirect()->route('admin.certificate-templates.index')
            ->with('success', 'Szablon certyfikatu został usunięty pomyślnie.');
    }
}
