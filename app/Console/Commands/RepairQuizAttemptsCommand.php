<?php

namespace App\Console\Commands;

use App\Models\QuizAttempt;
use App\Services\CertificateService;
use Illuminate\Console\Command;

class RepairQuizAttemptsCommand extends Command
{
    protected $signature = 'quiz:repair-pass 
                            {attempt_ids* : ID prób (np. 141 143 144)}
                            {--no-mail : Tylko zapis wyniku, bez certyfikatu i maila do podpisu}';

    protected $description = 'Uzupełnia nieukończone próby testu poprawnymi odpowiedziami, zalicza i (dla technika) uruchamia certyfikat + mail do podpisu.';

    public function handle(CertificateService $certificateService): int
    {
        $ids = array_map('intval', $this->argument('attempt_ids'));
        $noMail = $this->option('no-mail');

        foreach ($ids as $attemptId) {
            $attempt = QuizAttempt::with(['quiz.course'])->find($attemptId);
            if (!$attempt) {
                $this->error("Próba {$attemptId} nie istnieje.");

                return self::FAILURE;
            }

            if ($attempt->completed_at) {
                $this->warn("Próba {$attemptId} jest już ukończona — pomijam.");

                continue;
            }

            $answers = $this->buildPerfectAnswers($attempt);

            $attempt->update([
                'answers' => $answers,
                'completed_at' => now(),
            ]);

            $attempt->calculateScore();
            $attempt->percentage = $attempt->calculatePercentage();
            $attempt->passed = $attempt->checkIfPassed();
            $attempt->applyScoreMultiplier();
            $attempt->save();

            if (!$attempt->passed) {
                $this->error("Próba {$attemptId}: nie udało się zaliczyć (sprawdź kryteria testu).");

                return self::FAILURE;
            }

            $user = $attempt->user;
            $course = $attempt->quiz->course;

            $this->info("Próba {$attemptId}: zaliczona ({$attempt->percentage}%), user_id={$user->id}");

            if ($noMail) {
                continue;
            }

            if (!$user->isTechnician()) {
                $this->warn("Użytkownik {$user->id} nie jest technikiem — pomijam certyfikat do podpisu (tylko technicy).");

                continue;
            }

            $cert = $certificateService->issueTechnicianCertificateForSigning($user, $course, $attempt);
            if ($cert) {
                $this->info("  Certyfikat #{$cert->id}, numer {$cert->certificate_number} — wysyłka do podpisu wykonana (lub już był certyfikat).");
            } else {
                $this->warn('  Brak certyfikatu (szablon lub błąd — sprawdź logi).');
            }
        }

        return self::SUCCESS;
    }

    /**
     * @return array<int|string, mixed>
     */
    private function buildPerfectAnswers(QuizAttempt $attempt): array
    {
        $answers = [];

        foreach ($attempt->getSelectedQuestions() as $q) {
            switch ($q->type) {
                case 'single_choice':
                    $answers[$q->id] = $q->correct_answers[0];

                    break;
                case 'multiple_choice':
                    $copy = $q->correct_answers;
                    sort($copy);
                    $answers[$q->id] = array_values($copy);

                    break;
                case 'true_false':
                    $answers[$q->id] = $q->correct_answers[0];

                    break;
                default:
                    throw new \RuntimeException("Nieobsługiwany typ pytania: {$q->type}");
            }
        }

        return $answers;
    }
}
