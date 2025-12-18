<?php

namespace App\Console\Commands;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use App\Services\CertificateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateCertificateForUser extends Command
{
    protected $signature = 'certificate:generate {user_id} {course_id}';

    protected $description = 'Generate a certificate for a specific user and course.';

    public function handle(CertificateService $certificateService): int
    {
        $userId = $this->argument('user_id');
        $courseId = $this->argument('course_id');

        $user = User::find($userId);
        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return self::FAILURE;
        }

        $course = Course::find($courseId);
        if (!$course) {
            $this->error("Course with ID {$courseId} not found.");
            return self::FAILURE;
        }

        // Check if certificate already exists
        $existingCertificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingCertificate) {
            $this->warn("Certificate already exists for user {$user->name} (ID: {$user->id}) and course '{$course->title}' (ID: {$course->id}).");
            $this->info("Certificate ID: {$existingCertificate->id}");
            $this->info("Certificate Number: {$existingCertificate->certificate_number}");
            return self::SUCCESS;
        }

        // Check if course is completed
        if (!$course->isCompletedByUser($user)) {
            $this->warn("Course is not completed by user. Generating certificate anyway...");
        }

        // Check if user has passed the quiz
        $quiz = $course->quiz;
        $quizAttempt = null;
        if ($quiz) {
            if (!$quiz->hasUserPassed($user)) {
                $this->warn("User has not passed the quiz. Generating certificate anyway...");
            } else {
                $quizAttempt = $quiz->getUserBestAttempt($user);
            }
        }

        // Find appropriate template
        $template = $certificateService->findTemplateFor($user, $course);
        if (!$template) {
            $this->error("No certificate template found for user type '{$user->user_type}' and course ID {$course->id}.");
            return self::FAILURE;
        }

        $this->info("Found template: {$template->id}");

        // Create certificate
        try {
            $certificate = Certificate::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'certificate_template_id' => $template->id,
                'quiz_attempt_id' => $quizAttempt?->id,
                'certificate_number' => $certificateService->generateCertificateNumber($template),
                'issued_at' => now(),
                'expires_at' => now()->addYears(2),
            ]);

            $this->info("Certificate created with ID: {$certificate->id}");
            $this->info("Certificate Number: {$certificate->certificate_number}");

            // Generate PDF
            $this->info("Generating PDF...");
            $pdfPath = $certificateService->generateCertificatePDF($certificate);
            $certificate->update(['pdf_path' => $pdfPath]);

            $this->info("PDF generated successfully: {$pdfPath}");
            $this->info("Certificate generated successfully for {$user->name} (ID: {$user->id}) for course '{$course->title}' (ID: {$course->id}).");

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("Failed to generate certificate: {$e->getMessage()}");
            Log::error('Failed to generate certificate', [
                'user_id' => $user->id,
                'course_id' => $course->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return self::FAILURE;
        }
    }
}

