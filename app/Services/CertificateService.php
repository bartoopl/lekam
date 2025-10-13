<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\CertificateTemplate;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tcpdf\Fpdi;

class CertificateService
{
    /**
     * Generate certificate PDF using FPDI and template
     */
    public function generateCertificatePDF(Certificate $certificate): string
    {
        $user = $certificate->user;
        $course = $certificate->course;
        $template = $certificate->template;

        if (!$template) {
            throw new \Exception('No certificate template assigned');
        }

        // Check if template PDF exists
        if (!Storage::disk('public')->exists($template->pdf_path)) {
            throw new \Exception('Template PDF not found: ' . $template->pdf_path);
        }

        // Initialize FPDI with TCPDF in POINT units (not mm)
        // Parameters: orientation, unit, format, unicode, encoding, diskcache
        $pdf = new Fpdi('P', 'pt', 'A4', true, 'UTF-8', false);

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

        // Import ONLY first page (certificates usually have 1 page)
        $templateId = $pdf->importPage(1);

        // Get page dimensions
        $size = $pdf->getTemplateSize($templateId);

        // Add a page with same orientation and size as template
        $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
        $pdf->AddPage($orientation, [$size['width'], $size['height']]);

        // Use the imported page as template with exact dimensions
        $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

        // Set font for text
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->SetTextColor(0, 0, 0);

        // Get fields configuration
        $fields = $template->getFieldsConfig();

        // Prepare data to insert
        $data = $this->prepareDataFields($certificate, $user, $course);

        // Calculate center X position for all fields
        $centerX = $size['width'] / 2;

        // Render certificate content with formatting
        $this->renderCertificateContent($pdf, $fields, $data, $centerX, $size);

        // Generate filename
        $filename = 'certificates/' . $certificate->certificate_number . '.pdf';

        // Save PDF (TCPDF Output syntax: Output(name, destination))
        $output = $pdf->Output('certificate.pdf', 'S'); // Output as string
        Storage::disk('public')->put($filename, $output);

        return $filename;
    }

    /**
     * Prepare data fields for certificate
     */
    private function prepareDataFields(Certificate $certificate, User $user, Course $course): array
    {
        return [
            'certificate_number' => $certificate->certificate_number,
            'user_name' => $user->name,
            'course_title' => $course->title,
            'completion_date' => $certificate->issued_at->format('d.m.Y'),
            'points' => $course->getPointsForUser($user), // Just the number, no "pkt"
            'user_type' => $user->user_type === 'farmaceuta' ? 'Farmaceuta' : 'Technik Farmacji',
            'expiry_date' => $certificate->expires_at ? $certificate->expires_at->format('d.m.Y') : 'bezterminowy',
        ];
    }

    /**
     * Render all certificate content with static and dynamic text
     */
    private function renderCertificateContent($pdf, array $fields, array $data, float $centerX, array $size): void
    {
        // 1. ZAŚWIADCZENIE nr [numer] - BOLD
        if (isset($fields['certificate_number'])) {
            $y = $fields['certificate_number']['y'];
            $pdf->SetFont('dejavusans', 'B', $fields['certificate_number']['font_size'] ?? 12);
            $pdf->SetTextColor(0, 0, 0);
            $text = 'ZAŚWIADCZENIE nr ' . $data['certificate_number'];
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 2. Pan / Pani - above user_name (14px)
        if (isset($fields['user_name'])) {
            $y = $fields['user_name']['y'] - 20; // 20 points above name
            $pdf->SetFont('dejavusans', '', 14);
            $pdf->SetTextColor(0, 0, 0);
            // Simple gender detection based on name ending
            $userName = $data['user_name'];
            $prefix = (substr($userName, -1) === 'a') ? 'Pani' : 'Pan';
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
            $text = $data['user_name'];
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 4. "odbyła w dniu [data] kurs szkoleniowy:" (uses completion_date Y position)
        if (isset($fields['completion_date']) && isset($data['completion_date'])) {
            $y = $fields['completion_date']['y'];
            $fontSize = $fields['completion_date']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            // Use proper verb form based on gender
            $userName = $data['user_name'];
            $verb = (substr($userName, -1) === 'a') ? 'odbyła' : 'odbył';
            $text = $verb . ' w dniu ' . $data['completion_date'] . ' kurs szkoleniowy:';
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 5. Course title - centered
        if (isset($fields['course_title'])) {
            $y = $fields['course_title']['y'];
            $fontSize = $fields['course_title']['font_size'] ?? 14;
            $pdf->SetFont('dejavusans', 'B', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = $data['course_title'];
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 6. "liczba punktów edukacyjnych: [points]" (uses points Y position)
        if (isset($fields['points']) && isset($data['points'])) {
            $y = $fields['points']['y'];
            $fontSize = $fields['points']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = 'liczba punktów edukacyjnych: ' . $data['points'] . ' pkt';
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 7. "Gdańsk, dnia [data]" (uses expiry_date Y position)
        if (isset($fields['expiry_date']) && isset($data['completion_date'])) {
            $y = $fields['expiry_date']['y'];
            $fontSize = $fields['expiry_date']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = 'Gdańsk, dnia ' . $data['completion_date']; // Use completion date here
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }
    }

    /**
     * Insert text field on PDF
     */
    private function insertTextField(Fpdi $pdf, string $text, array $config, float $pageWidth): void
    {
        $x = $config['x'] ?? 0;
        $y = $config['y'] ?? 0;
        $fontSize = $config['font_size'] ?? 12;
        $align = $config['align'] ?? 'left';

        // Skip if coordinates are 0,0 (field not configured)
        if ($x == 0 && $y == 0) {
            return;
        }

        $pdf->SetFont('dejavusans', '', $fontSize);
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
     * Find or create template for user and course
     */
    public function findTemplateFor(User $user, Course $course): ?CertificateTemplate
    {
        return CertificateTemplate::findTemplateFor($user, $course);
    }

    /**
     * Generate certificate number using template
     */
    public function generateCertificateNumber(CertificateTemplate $template): string
    {
        return $template->generateNextCertificateNumber();
    }
}
