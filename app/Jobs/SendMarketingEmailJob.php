<?php

namespace App\Jobs;

use App\Mail\MarketingScenarioMail;
use App\Models\MarketingDeliveryLog;
use App\Models\MarketingScenario;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMarketingEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $logId,
        public int $userId,
        public string $subjectLine,
        public string $body
    ) {
    }

    public function handle(): void
    {
        $log = MarketingDeliveryLog::find($this->logId);
        $user = User::find($this->userId);

        if (!$log || !$user || empty($user->email)) {
            return;
        }

        $scenario = MarketingScenario::find($log->marketing_scenario_id);
        if (!$scenario || !$this->hasRequiredConsent($user, $scenario)) {
            $log->update([
                'status' => 'skipped',
                'error_message' => 'Required consent is not granted for this scenario.',
            ]);
            return;
        }

        $content = str_replace(
            ['{name}', '{email}'],
            [$user->name, $user->email],
            $this->body
        );

        try {
            Mail::to($user->email)->send(new MarketingScenarioMail($this->subjectLine, $content));
            $log->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } catch (\Throwable $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }

    private function hasRequiredConsent(User $user, MarketingScenario $scenario): bool
    {
        return match ($scenario->requiredConsentColumn()) {
            'consent_1' => (bool) $user->consent_1,
            'consent_3' => (bool) $user->consent_3,
            default => (bool) $user->consent_2,
        };
    }
}
