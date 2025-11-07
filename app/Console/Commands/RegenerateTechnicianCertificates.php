<?php

namespace App\Console\Commands;

use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RegenerateTechnicianCertificates extends Command
{
    protected $signature = 'certificates:regenerate-technicians {--dry-run : Show how many certificates would be regenerated without modifying files}';

    protected $description = 'Regenerate PDF files for certificates issued to pharmacy technicians using the latest template logic.';

    public function handle(CertificateService $certificateService): int
    {
        $query = Certificate::with(['user', 'course'])
            ->whereHas('user', function ($builder) {
                $builder->where('user_type', 'technik_farmacji');
            })
            ->orderBy('id');

        $total = (clone $query)->count();

        if ($total === 0) {
            $this->info('No technician certificates found that require regeneration.');
            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->info("[DRY RUN] Certificates that would be regenerated: {$total}");
            return self::SUCCESS;
        }

        $this->info("Regenerating {$total} certificate PDF(s) for technicians...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $regenerated = 0;
        $failed = 0;

        $query->chunkById(100, function ($certificates) use ($certificateService, $bar, &$regenerated, &$failed) {
            foreach ($certificates as $certificate) {
                try {
                    $pdfPath = $certificateService->generateCertificatePDF($certificate);
                    $certificate->forceFill(['pdf_path' => $pdfPath])->save();
                    $regenerated++;
                } catch (\Throwable $throwable) {
                    $failed++;
                    Log::error('Failed to regenerate technician certificate', [
                        'certificate_id' => $certificate->id,
                        'user_id' => $certificate->user_id,
                        'error' => $throwable->getMessage(),
                    ]);
                    $this->warn(PHP_EOL . " - Failed certificate ID {$certificate->id}: {$throwable->getMessage()}");
                } finally {
                    $bar->advance();
                }
            }
        });

        $bar->finish();
        $this->newLine(2);

        $this->info("Regenerated: {$regenerated}");

        if ($failed > 0) {
            $this->error("Failed: {$failed}");
            return self::FAILURE;
        }

        $this->info('All technician certificates have been regenerated successfully.');

        return self::SUCCESS;
    }
}


