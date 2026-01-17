<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\CertificateTemplate;
use App\Models\User;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;
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
            return $this->generateFallbackPdf($certificate);
        }

        // Check if template PDF exists
        if (!Storage::disk('public')->exists($template->pdf_path)) {
            return $this->generateFallbackPdf($certificate);
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
        $filename = 'certificates/' . $this->buildCertificateFilename($certificate);

        // Save PDF (TCPDF Output syntax: Output(name, destination))
        $output = $pdf->Output('certificate.pdf', 'S'); // Output as string
        Storage::disk('public')->put($filename, $output);

        return $filename;
    }

    /**
     * Fallback generator when template PDF is not available
     */
    private function generateFallbackPdf(Certificate $certificate): string
    {
        $data = [
            'certificate' => $certificate,
            'user' => $certificate->user,
            'course' => $certificate->course,
            'quizAttempt' => $certificate->quizAttempt,
            'fallback_prefix' => $this->getPersonPrefix($certificate->user),
            'fallback_verb' => $this->getCompletionVerb($certificate->user),
        ];

        $pdf = Pdf::loadView('certificates.pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        $filename = 'certificates/' . $this->buildCertificateFilename($certificate);

        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Prepare data fields for certificate
     */
    private function prepareDataFields(Certificate $certificate, User $user, Course $course): array
    {
        // Calculate duration in hours (round up)
        $durationHours = $course->duration_minutes ? ceil($course->duration_minutes / 60) : 0;

        return [
            'certificate_number' => $certificate->certificate_number,
            'user_name' => $user->name,
            'course_title' => $course->title,
            'completion_date' => $certificate->issued_at->format('d.m.Y'),
            'points' => $course->getPointsForUser($user), // Just the number, no "pkt"
            'duration_hours' => $durationHours, // Duration in hours
            'user_type' => $user->user_type === 'farmaceuta' ? 'Farmaceuta' : 'Technik Farmacji',
            'user_raw_type' => $user->user_type,
            'pwz_number' => $user->pwz_number,
            'expiry_date' => $certificate->expires_at ? $certificate->expires_at->format('d.m.Y') : 'bezterminowy',
        ];
    }

    private function getPersonPrefix(User $user): string
    {
        if ($user->isTechnician()) {
            return 'Pan/Pani';
        }

        return str_ends_with(mb_strtolower($user->name), 'a') ? 'Pani' : 'Pan';
    }

    private function getCompletionVerb(User $user): string
    {
        if ($user->isTechnician()) {
            return 'odbył/a';
        }

        return str_ends_with(mb_strtolower($user->name), 'a') ? 'odbyła' : 'odbył';
    }

    private function buildCertificateFilename(Certificate $certificate): string
    {
        $baseName = preg_replace('/[^A-Za-z0-9_-]+/', '_', $certificate->certificate_number);

        return trim($baseName, '_') . '.pdf';
    }

    /**
     * Render all certificate content with static and dynamic text
     */
    private function renderCertificateContent($pdf, array $fields, array $data, float $centerX, array $size): void
    {
        // 1. ZAŚWIADCZENIE nr [numer] - BOLD
        // Dla technika farmacji: "Numer PWZ: [pwz] ZAŚWIADCZENIE nr [numer]"
        if (isset($fields['certificate_number'])) {
            $y = $fields['certificate_number']['y'];
            $pdf->SetFont('dejavusans', 'B', $fields['certificate_number']['font_size'] ?? 12);
            $pdf->SetTextColor(0, 0, 0);
            
            $isTechnician = ($data['user_raw_type'] ?? null) === 'technik_farmacji';
            $pwzNumber = $data['pwz_number'] ?? null;
            
            if ($isTechnician && $pwzNumber) {
                // Dla technika farmacji z numerem PWZ
                $text = 'Numer PWZ: ' . $pwzNumber . ' ZAŚWIADCZENIE nr ' . $data['certificate_number'];
            } else {
                // Dla farmaceuty lub technika bez PWZ - standardowy format
                $text = 'ZAŚWIADCZENIE nr ' . $data['certificate_number'];
            }
            
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 2. Pan / Pani - above user_name (14px)
        if (isset($fields['user_name'])) {
            $y = $fields['user_name']['y'] - 20; // 20 points above name
            $pdf->SetFont('dejavusans', '', 14);
            $pdf->SetTextColor(0, 0, 0);
            $userName = $data['user_name'];
            $isTechnician = ($data['user_raw_type'] ?? null) === 'technik_farmacji';
            $prefix = $isTechnician ? 'Pan/Pani' : (str_ends_with(mb_strtolower($userName), 'a') ? 'Pani' : 'Pan');
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
            $isTechnician = ($data['user_raw_type'] ?? null) === 'technik_farmacji';
            $verb = $isTechnician ? 'odbył/a' : (str_ends_with(mb_strtolower($userName), 'a') ? 'odbyła' : 'odbył');
            // For technik_farmacji (with course_subtitle), only show "odbył w dniu [data]"
            // For farmaceuta (without course_subtitle), show full text with "kurs szkoleniowy:"
            if (isset($fields['course_subtitle'])) {
                $text = $verb . ' w dniu ' . $data['completion_date'];
            } else {
                $text = $verb . ' w dniu ' . $data['completion_date'] . ' kurs szkoleniowy:';
            }
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 4b. Course subtitle - optional additional text before course title (for technik_farmacji)
        if (isset($fields['course_subtitle']) && isset($data['completion_date'])) {
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
            $text = $data['course_title'];

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

        // 6b. Duration hours - optional (for technik_farmacji)
        if (isset($fields['duration_hours']) && isset($data['duration_hours'])) {
            $y = $fields['duration_hours']['y'];
            $fontSize = $fields['duration_hours']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = 'liczba godzin szkoleniowych: ' . $data['duration_hours'] . ' godz.';
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        }

        // 7. City and date - uses city from template config or defaults to Gdańsk
        if (isset($fields['city']) && isset($data['completion_date'])) {
            $y = $fields['city']['y'];
            $fontSize = $fields['city']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            // Get city from config, default to Gdańsk
            $city = $fields['city']['value'] ?? 'Gdańsk';
            $text = $city . ', dnia ' . $data['completion_date'];
            $textWidth = $pdf->GetStringWidth($text);
            $pdf->SetXY($centerX - ($textWidth / 2), $y);
            $pdf->Cell($textWidth, 10, $text, 0, 0, 'L');
        } elseif (isset($fields['expiry_date']) && isset($data['completion_date'])) {
            // Fallback to old field name for backward compatibility
            $y = $fields['expiry_date']['y'];
            $fontSize = $fields['expiry_date']['font_size'] ?? 12;
            $pdf->SetFont('dejavusans', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $text = 'Gdańsk, dnia ' . $data['completion_date'];
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
