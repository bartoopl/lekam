<?php

namespace App\Console\Commands;

use App\Jobs\SendMarketingEmailJob;
use App\Jobs\SendMarketingSmsJob;
use App\Models\MarketingDeliveryLog;
use App\Models\MarketingScenario;
use App\Models\MarketingScenarioRun;
use App\Services\MarketingRecipientResolver;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DispatchMarketingScenarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marketing:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch due marketing scenarios';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $recipientResolver = app(MarketingRecipientResolver::class);
        $dueScenarios = MarketingScenario::where('is_active', true)->get()->filter(
            fn (MarketingScenario $scenario) => $scenario->isDue(now())
        );

        foreach ($dueScenarios as $scenario) {
            $run = MarketingScenarioRun::create([
                'marketing_scenario_id' => $scenario->id,
                'scheduled_for' => now(),
                'status' => 'processing',
            ]);

            $recipients = $recipientResolver->resolve($scenario);
            if ($scenario->dry_run) {
                $run->update([
                    'status' => 'completed',
                    'dispatched_at' => now(),
                    'notes' => 'Dry-run: estimated recipients=' . $recipients->count(),
                ]);
                $scenario->update([
                    'last_dispatched_at' => now(),
                ]);
                continue;
            }

            $scenarioRunLimit = max(1, (int) config('services.smsapi.scenario_run_limit', 200));
            $recipients = $recipients->take($scenarioRunLimit);

            foreach ($recipients as $user) {
                if (in_array($scenario->channel, ['email', 'both'], true)) {
                    $emailLog = MarketingDeliveryLog::firstOrCreate([
                        'marketing_scenario_id' => $scenario->id,
                        'marketing_scenario_run_id' => $run->id,
                        'user_id' => $user->id,
                        'channel' => 'email',
                    ], [
                        'status' => 'queued',
                    ]);

                    SendMarketingEmailJob::dispatch(
                        $emailLog->id,
                        $user->id,
                        (string) $scenario->email_subject,
                        (string) $scenario->email_body
                    )->onQueue('marketing');
                }

                if (in_array($scenario->channel, ['sms', 'both'], true)) {
                    $smsSkipReason = $this->getSmsSkipReason($scenario, (int) $user->id);
                    if ($smsSkipReason !== null) {
                        MarketingDeliveryLog::firstOrCreate([
                            'marketing_scenario_id' => $scenario->id,
                            'marketing_scenario_run_id' => $run->id,
                            'user_id' => $user->id,
                            'channel' => 'sms',
                        ], [
                            'status' => 'skipped',
                            'error_message' => $smsSkipReason,
                        ]);
                        continue;
                    }

                    $smsLog = MarketingDeliveryLog::firstOrCreate([
                        'marketing_scenario_id' => $scenario->id,
                        'marketing_scenario_run_id' => $run->id,
                        'user_id' => $user->id,
                        'channel' => 'sms',
                    ], [
                        'status' => 'queued',
                    ]);

                    SendMarketingSmsJob::dispatch(
                        $smsLog->id,
                        $user->id,
                        (string) $scenario->sms_body
                    )->onQueue('marketing');
                }
            }

            $run->update([
                'status' => 'completed',
                'dispatched_at' => now(),
            ]);

            $scenario->update([
                'last_dispatched_at' => now(),
            ]);
        }

        $this->info('Marketing scenarios dispatched.');
        return self::SUCCESS;
    }

    private function getSmsSkipReason(MarketingScenario $scenario, int $userId): ?string
    {
        if (!config('services.smsapi.enabled', false)) {
            return 'SMS channel is disabled by configuration (SMSAPI_ENABLED=false).';
        }

        if ($this->isInQuietHours()) {
            return 'SMS dispatch blocked by quiet hours window.';
        }

        $todayStart = Carbon::now()->startOfDay();
        $dailyLimit = max(1, (int) config('services.smsapi.daily_limit', 1000));
        $sentToday = MarketingDeliveryLog::query()
            ->where('channel', 'sms')
            ->whereIn('status', ['queued', 'sent'])
            ->where('created_at', '>=', $todayStart)
            ->count();
        if ($sentToday >= $dailyLimit) {
            return 'SMS daily limit reached.';
        }

        $cooldownHours = max(1, (int) config('services.smsapi.per_user_cooldown_hours', 24));
        $cooldownBoundary = Carbon::now()->subHours($cooldownHours);
        $recentForUser = MarketingDeliveryLog::query()
            ->where('channel', 'sms')
            ->where('user_id', $userId)
            ->where('marketing_scenario_id', $scenario->id)
            ->whereIn('status', ['queued', 'sent'])
            ->where('created_at', '>=', $cooldownBoundary)
            ->exists();
        if ($recentForUser) {
            return 'SMS per-user cooldown still active.';
        }

        return null;
    }

    private function isInQuietHours(): bool
    {
        $now = Carbon::now('Europe/Warsaw');
        $start = Carbon::createFromFormat('H:i', (string) config('services.smsapi.quiet_hours_start', '20:00'), 'Europe/Warsaw');
        $end = Carbon::createFromFormat('H:i', (string) config('services.smsapi.quiet_hours_end', '08:00'), 'Europe/Warsaw');

        if ($start->lessThan($end)) {
            return $now->betweenIncluded($start, $end);
        }

        return $now->greaterThanOrEqualTo($start) || $now->lessThanOrEqualTo($end);
    }
}
