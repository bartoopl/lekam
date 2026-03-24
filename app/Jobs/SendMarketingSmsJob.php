<?php

namespace App\Jobs;

use App\Models\MarketingDeliveryLog;
use App\Models\User;
use App\Services\SmsApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMarketingSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $logId,
        public int $userId,
        public string $body
    ) {
    }

    public function handle(SmsApiService $smsApiService): void
    {
        $log = MarketingDeliveryLog::find($this->logId);
        $user = User::find($this->userId);

        if (!$log || !$user) {
            return;
        }

        if (empty($user->phone) || !$user->consent_2) {
            $log->update([
                'status' => 'skipped',
                'error_message' => 'Missing phone number or consent_2 is not granted.',
            ]);
            return;
        }

        $content = str_replace(
            ['{name}', '{email}'],
            [$user->name, $user->email],
            $this->body
        );

        try {
            $response = $smsApiService->send($user->phone, $content);

            $log->update([
                'status' => 'sent',
                'provider_message_id' => $response['provider_message_id'],
                'sent_at' => now(),
                'meta' => $response['raw'],
            ]);
        } catch (\Throwable $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
