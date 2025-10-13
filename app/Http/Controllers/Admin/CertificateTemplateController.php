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

        return redirect()->route('admin.certificate-templates.edit', $template)
            ->with('success', 'Szablon certyfikatu został zaktualizowany pomyślnie.');
    }

    /**
     * Generate demo certificate with sample data
     */
    public function generateDemo(CertificateTemplate $template)
    {
        try {
            // Check if template PDF exists
            if (!Storage::disk('public')->exists($template->pdf_path)) {
                return back()->with('error', 'Plik PDF szablonu nie został znaleziony.');
            }

            // Initialize FPDI
            $pdf = new \setasign\Fpdi\Fpdi();

            // Get template file path
            $templatePath = Storage::disk('public')->path($template->pdf_path);

            // Set source file
            $pageCount = $pdf->setSourceFile($templatePath);

            // Import ONLY first page (template should have only 1 page)
            $templateId = $pdf->importPage(1);

            // Get page dimensions
            $size = $pdf->getTemplateSize($templateId);

            // Get fields configuration
            $fields = $template->getFieldsConfig();

            // Demo data
            $demoData = [
                'certificate_number' => 'DEMO/001/2025',
                'user_name' => 'Jan Kowalski',
                'course_title' => 'Przykladowy kurs szkoleniowy',
                'completion_date' => date('d.m.Y'),
                'points' => '50 pkt',
                'user_type' => 'Farmaceuta',
                'expiry_date' => date('d.m.Y', strtotime('+2 years')),
            ];

            // Add a page with same orientation and size as template
            $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
            $pdf->AddPage($orientation, [$size['width'], $size['height']]);

            // Use the imported page as template FIRST (as background)
            $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

            // NOW add text ON TOP of template
            $pdf->SetFont('helvetica', '', 12);
            $pdf->SetTextColor(0, 0, 0);

            // DEBUG: Draw grid to see coordinate system
            $pdf->SetDrawColor(200, 200, 200);
            $pdf->SetLineWidth(0.5);

            // Vertical lines every 50 points
            for ($x = 0; $x <= $size['width']; $x += 50) {
                $pdf->Line($x, 0, $x, $size['height']);
            }

            // Horizontal lines every 50 points
            for ($y = 0; $y <= $size['height']; $y += 50) {
                $pdf->Line(0, $y, $size['width'], $y);
            }

            // Add coordinate labels
            $pdf->SetFont('helvetica', '', 8);
            $pdf->SetTextColor(100, 100, 100);
            for ($x = 0; $x <= $size['width']; $x += 100) {
                $pdf->SetXY($x + 2, 2);
                $pdf->Cell(20, 5, "X:$x", 0, 0, 'L');
            }
            for ($y = 0; $y <= $size['height']; $y += 100) {
                $pdf->SetXY(2, $y + 2);
                $pdf->Cell(20, 5, "Y:$y", 0, 0, 'L');
            }

            // DEBUG: Add visible markers at corners
            $pdf->SetDrawColor(255, 0, 0);
            $pdf->SetLineWidth(2);
            $pdf->Rect(10, 10, 30, 30, 'D'); // Top-left
            $pdf->Rect($size['width'] - 40, 10, 30, 30, 'D'); // Top-right
            $pdf->Rect(10, $size['height'] - 40, 30, 30, 'D'); // Bottom-left
            $pdf->Rect($size['width'] - 40, $size['height'] - 40, 30, 30, 'D'); // Bottom-right

            // Show page size
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetXY(10, 50);
            $pdf->Cell(0, 10, 'Size: ' . round($size['width']) . ' x ' . round($size['height']), 0, 0, 'L');

            // NOW render the actual demo data fields
            foreach ($fields as $fieldName => $config) {
                if (isset($demoData[$fieldName])) {
                    // Draw a red circle at the field position to mark it
                    $pdf->SetDrawColor(255, 0, 0);
                    $pdf->SetFillColor(255, 0, 0);
                    $pdf->Circle($config['x'], $config['y'], 3, 0, 360, 'F');

                    // Add a label showing what field this is
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->SetTextColor(255, 0, 0);
                    $pdf->SetXY($config['x'] + 5, $config['y'] - 3);
                    $pdf->Cell(100, 5, $fieldName, 0, 0, 'L');

                    // Now render the actual field
                    $this->insertTextField($pdf, $demoData[$fieldName], $config, $size['width']);
                }
            }

            // Generate filename
            $filename = 'demo_certificate_' . $template->id . '_' . time() . '.pdf';

            // Output PDF to browser
            return response($pdf->Output('S', $filename), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Błąd podczas generowania demo certyfikatu: ' . $e->getMessage());
        }
    }

    /**
     * Insert text field on PDF (helper method for demo generation)
     */
    private function insertTextField($pdf, string $text, array $config, float $pageWidth): void
    {
        $x = $config['x'] ?? 0;
        $y = $config['y'] ?? 0;
        $fontSize = $config['font_size'] ?? 12;
        $align = $config['align'] ?? 'left';

        // Skip if coordinates are 0,0 (field not configured)
        if ($x == 0 && $y == 0) {
            return;
        }

        $pdf->SetFont('helvetica', '', $fontSize);
        $pdf->SetTextColor(0, 0, 0); // Ensure black text

        // Convert text to ISO-8859-2 for proper Polish characters display
        $text = iconv('UTF-8', 'ISO-8859-2//TRANSLIT', $text);

        if ($align === 'center') {
            // For center alignment, center around X coordinate
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($x - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        } elseif ($align === 'right') {
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($x - $textWidth, $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        } else {
            $pdf->SetXY($x, $y);
            $pdf->Cell(0, 10, $text, 0, 0, 'L');
        }
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
