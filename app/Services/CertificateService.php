<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\CertificateTemplate;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

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

        // Initialize FPDI
        $pdf = new Fpdi();

        // Get template file path
        $templatePath = Storage::disk('public')->path($template->pdf_path);

        // Set source file
        $pageCount = $pdf->setSourceFile($templatePath);

        // Import first page (certificates usually have 1 page)
        $templateId = $pdf->importPage(1);

        // Get page dimensions
        $size = $pdf->getTemplateSize($templateId);

        // Add a page with same orientation and size as template
        $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
        $pdf->AddPage($orientation, [$size['width'], $size['height']]);

        // Use the imported page as template
        $pdf->useTemplate($templateId);

        // Set font for text
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(0, 0, 0);

        // Get fields configuration
        $fields = $template->getFieldsConfig();

        // Prepare data to insert
        $data = $this->prepareDataFields($certificate, $user, $course);

        // Insert text fields
        foreach ($fields as $fieldName => $config) {
            if (isset($data[$fieldName])) {
                $this->insertTextField($pdf, $data[$fieldName], $config, $size['width']);
            }
        }

        // Generate filename
        $filename = 'certificates/' . $certificate->certificate_number . '.pdf';

        // Save PDF
        $output = $pdf->Output('S'); // Output as string
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
            'points' => $course->getPointsForUser($user) . ' pkt',
            'user_type' => $user->user_type === 'farmaceuta' ? 'Farmaceuta' : 'Technik Farmacji',
            'expiry_date' => $certificate->expires_at ? $certificate->expires_at->format('d.m.Y') : 'bezterminowy',
        ];
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
