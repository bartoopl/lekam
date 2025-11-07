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

            // Initialize FPDI with TCPDF in POINT units (not mm)
            // Parameters: orientation, unit, format, unicode, encoding, diskcache
            $pdf = new \setasign\Fpdi\Tcpdf\Fpdi('P', 'pt', 'A4', true, 'UTF-8', false);

            // Disable automatic page breaks
            $pdf->SetAutoPageBreak(false, 0);

            // Set margins to 0 for full control
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);

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

            // Demo data (only actual dynamic values)
            $demoUserType = $template->user_type ?? 'farmaceuta';
            $demoData = [
                'certificate_number' => 'DEMO/001/2025',
                'user_name' => 'Jan Kowalski',
                'course_title' => 'Przykładowy kurs szkoleniowy',
                'completion_date' => date('d.m.Y'),
                'points' => '50',
                'duration_hours' => '10',
                'user_type' => $demoUserType === 'technik_farmacji' ? 'Technik Farmacji' : 'Farmaceuta',
                'user_raw_type' => $demoUserType,
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

            // Calculate center X position for all fields
            $centerX = $size['width'] / 2;

            // Render static and dynamic content
            $this->renderCertificateContent($pdf, $fields, $demoData, $centerX, $size);

            // Generate filename
            $filename = 'demo_certificate_' . $template->id . '_' . time() . '.pdf';

            // Output PDF as string for response
            $pdfContent = $pdf->Output($filename, 'S');

            // Return PDF to browser
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Błąd podczas generowania demo certyfikatu: ' . $e->getMessage());
        }
    }

    /**
     * Render all certificate content with static and dynamic text
     */
    private function renderCertificateContent($pdf, array $fields, array $demoData, float $centerX, array $size): void
    {
        // 1. ZAŚWIADCZENIE nr [numer] - BOLD
        if (isset($fields['certificate_number'])) {
            $y = $fields['certificate_number']['y'];
            $pdf->SetFont('dejavusans', 'B', $fields['certificate_number']['font_size'] ?? 12);
            $pdf->SetTextColor(0, 0, 0);
            $text = 'ZAŚWIADCZENIE nr ' . $demoData['certificate_number'];
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 2. Pan / Pani - above user_name (14px)
        if (isset($fields['user_name'])) {
            $y = $fields['user_name']['y'] - 20; // 20 points above name
            $pdf->SetFont('dejavusans', '', 14);
            $pdf->SetTextColor(0, 0, 0);
            $userName = $demoData['user_name'];
            $isTechnician = ($demoData['user_raw_type'] ?? null) === 'technik_farmacji';
            $prefix = $isTechnician ? 'Pan/Pani' : ((substr($userName, -1) === 'a') ? 'Pani' : 'Pan');
            $textWidth = $pdf->GetStringWidth($prefix);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $prefix, 0, 0, 'L');
        }

        // 3. User name - BOLD and centered
        if (isset($fields['user_name'])) {
            $y = $fields['user_name']['y'];
            $fontSize = $fields['user_name']['font_size'] ?? 20;
            $pdf->SetFont('dejavusans', 'B', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = $demoData['user_name'];
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 4. "odbyła w dniu [data] kurs szkoleniowy:" (uses completion_date Y position)
        if (isset($fields['completion_date']) && isset($demoData['completion_date'])) {
            $y = $fields['completion_date']['y'];
            $fontSize = $fields['completion_date']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            // Use proper verb form based on gender
            $userName = $demoData['user_name'];
            $isTechnician = ($demoData['user_raw_type'] ?? null) === 'technik_farmacji';
            $verb = $isTechnician ? 'odbył/a' : ((substr($userName, -1) === 'a') ? 'odbyła' : 'odbył');
            // For technik_farmacji (with course_subtitle), only show "odbył w dniu [data]"
            // For farmaceuta (without course_subtitle), show full text with "kurs szkoleniowy:"
            if (isset($fields['course_subtitle'])) {
                $text = $verb . ' w dniu ' . $demoData['completion_date'];
            } else {
                $text = $verb . ' w dniu ' . $demoData['completion_date'] . ' kurs szkoleniowy:';
            }
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 4b. Course subtitle - optional additional text before course title (for technik_farmacji)
        if (isset($fields['course_subtitle']) && isset($demoData['completion_date'])) {
            $y = $fields['course_subtitle']['y'];
            $fontSize = $fields['course_subtitle']['font_size'] ?? 11;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            // Two-line text with line break before "z ograniczonym dostępem"
            $text = "kurs szkoleniowy realizowany za pośrednictwem sieci internetowej\nz ograniczonym dostępem zakończony testem";

            // Calculate maximum width (80% of page width)
            $maxWidth = $size['width'] * 0.8;

            // Use MultiCell for multi-line text with center alignment
            $startX = $centerX - ($maxWidth / 2);
            $pdf->SetXY($startX, $y);
            $pdf->MultiCell($maxWidth, 12, $text, 0, 'C', false, 1);
        }

        // 5. Course title - centered with multiline support
        if (isset($fields['course_title'])) {
            $y = $fields['course_title']['y'];
            $fontSize = $fields['course_title']['font_size'] ?? 14;
            $pdf->SetFont('dejavusans', 'B', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = $demoData['course_title'];

            // Calculate maximum width (80% of page width to leave margins)
            $maxWidth = $size['width'] * 0.8;

            // Check if text fits in one line
            $textWidth = $pdf->GetStringWidth($text);

            if ($textWidth <= $maxWidth) {
                // Single line - center it
                $pdf->SetXY($centerX - ($textWidth / 2), $y);
                $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
            } else {
                // Multi-line - use MultiCell with center alignment
                $startX = $centerX - ($maxWidth / 2);
                $pdf->SetXY($startX, $y);
                $pdf->MultiCell($maxWidth, 15, $text, 0, 'C', false, 1);
            }
        }

        // 6. "liczba punktów edukacyjnych: [points]" (uses points Y position)
        if (isset($fields['points']) && isset($demoData['points'])) {
            $y = $fields['points']['y'];
            $fontSize = $fields['points']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = 'liczba punktów edukacyjnych: ' . $demoData['points'] . ' pkt';
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 6b. Duration hours - optional (for technik_farmacji)
        if (isset($fields['duration_hours']) && isset($demoData['duration_hours'])) {
            $y = $fields['duration_hours']['y'];
            $fontSize = $fields['duration_hours']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = 'liczba godzin szkoleniowych: ' . $demoData['duration_hours'] . ' godz.';
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 7. City and date - uses city from template config or defaults to Gdańsk
        if (isset($fields['city']) && isset($demoData['completion_date'])) {
            $y = $fields['city']['y'];
            $fontSize = $fields['city']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            // Get city from config, default to Gdańsk
            $city = $fields['city']['value'] ?? 'Gdańsk';
            $text = $city . ', dnia ' . $demoData['completion_date'];
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        } elseif (isset($fields['expiry_date']) && isset($demoData['completion_date'])) {
            // Fallback to old field name for backward compatibility
            $y = $fields['expiry_date']['y'];
            $fontSize = $fields['expiry_date']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = 'Gdańsk, dnia ' . $demoData['completion_date'];
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
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

        // TCPDF with UTF-8 handles Polish characters natively, no conversion needed

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
