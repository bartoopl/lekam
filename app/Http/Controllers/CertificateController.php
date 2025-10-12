<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\QuizAttempt;
use App\Services\CertificateService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * Generate certificate for course completion
     */
    public function generate(Course $course, CertificateService $certificateService)
    {
        \Log::info('Certificate generation requested', ['course_id' => $course->id, 'user_id' => auth()->id()]);

        $user = Auth::user();

        if (!$user) {
            \Log::error('User not authenticated for certificate generation');
            return redirect()->route('login');
        }

        // Check if course is completed
        if (!$course->isCompletedByUser($user)) {
            \Log::warning('Course not completed for certificate', ['course_id' => $course->id, 'user_id' => $user->id]);
            return redirect()->route('courses.show', $course)
                ->with('error', 'Musisz ukończyć kurs przed otrzymaniem certyfikatu.');
        }

        // Check if user has passed the quiz
        $quiz = $course->quiz;
        if ($quiz && !$quiz->hasUserPassed($user)) {
            \Log::warning('Quiz not passed for certificate', ['course_id' => $course->id, 'user_id' => $user->id, 'quiz_id' => $quiz->id]);
            return redirect()->route('courses.show', $course)
                ->with('error', 'Musisz zdać test przed otrzymaniem certyfikatu.');
        }

        // Check if certificate already exists
        $existingCertificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingCertificate) {
            \Log::info('Certificate already exists, downloading directly', ['certificate_id' => $existingCertificate->id]);
            return $this->download($existingCertificate);
        }

        // Find appropriate template
        $template = $certificateService->findTemplateFor($user, $course);

        if (!$template) {
            \Log::error('No certificate template found', ['user_type' => $user->user_type, 'course_id' => $course->id]);
            return redirect()->route('courses.show', $course)
                ->with('error', 'Brak dostępnego szablonu certyfikatu. Skontaktuj się z administratorem.');
        }

        // Get best quiz attempt
        $quizAttempt = null;
        if ($quiz) {
            $quizAttempt = $quiz->getUserBestAttempt($user);
            \Log::info('Found best quiz attempt', ['attempt_id' => $quizAttempt?->id, 'score' => $quizAttempt?->score]);
        }

        \Log::info('Creating new certificate', ['course_id' => $course->id, 'user_id' => $user->id, 'template_id' => $template->id]);

        // Create certificate
        $certificate = Certificate::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'certificate_template_id' => $template->id,
            'quiz_attempt_id' => $quizAttempt?->id,
            'certificate_number' => $certificateService->generateCertificateNumber($template),
            'issued_at' => now(),
            'expires_at' => now()->addYears(2), // Certyfikat ważny 2 lata
        ]);

        \Log::info('Certificate created, generating PDF', ['certificate_id' => $certificate->id]);

        // Generate PDF
        try {
            $pdfPath = $certificateService->generateCertificatePDF($certificate);
            $certificate->update(['pdf_path' => $pdfPath]);
            \Log::info('PDF generated successfully', ['certificate_id' => $certificate->id, 'pdf_path' => $pdfPath]);
        } catch (\Exception $e) {
            \Log::error('Error generating PDF', ['certificate_id' => $certificate->id, 'error' => $e->getMessage()]);
            return redirect()->route('courses.show', $course)
                ->with('error', 'Błąd podczas generowania certyfikatu: ' . $e->getMessage());
        }

        \Log::info('Certificate generated, downloading directly', ['certificate_id' => $certificate->id]);
        return $this->download($certificate);
    }

    /**
     * Show certificate
     */
    public function show(Certificate $certificate)
    {
        $user = Auth::user();
        
        if (!$user || $certificate->user_id !== $user->id) {
            return redirect()->route('home');
        }

        return view('certificates.show', compact('certificate'));
    }

    /**
     * Download certificate PDF
     */
    public function download(Certificate $certificate)
    {
        $user = Auth::user();
        
        if (!$user || $certificate->user_id !== $user->id) {
            return redirect()->route('home');
        }

        if (!$certificate->pdf_path || !Storage::disk('public')->exists($certificate->pdf_path)) {
            // Regenerate PDF if it doesn't exist
            $this->generateCertificatePDF($certificate);
        }

        return Storage::disk('public')->download($certificate->pdf_path);
    }

    /**
     * Generate certificate PDF
     */
    private function generateCertificatePDF(Certificate $certificate)
    {
        $data = [
            'certificate' => $certificate,
            'user' => $certificate->user,
            'course' => $certificate->course,
            'quizAttempt' => $certificate->quizAttempt,
        ];

        $pdf = PDF::loadView('certificates.pdf', $data);
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');
        
        // Generate filename
        $filename = 'certificates/' . $certificate->certificate_number . '.pdf';
        
        // Save PDF
        Storage::disk('public')->put($filename, $pdf->output());
        
        // Update certificate with PDF path
        $certificate->update(['pdf_path' => $filename]);
    }

    /**
     * Show user's certificates
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $certificates = $user->certificates()
            ->with(['course'])
            ->orderBy('issued_at', 'desc')
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }
}
