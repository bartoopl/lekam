<?php

namespace App\Jobs;

use App\Mail\MarketingScenarioMail;
use App\Models\MarketingDeliveryLog;
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
}
