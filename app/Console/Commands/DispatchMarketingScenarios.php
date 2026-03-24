<?php

namespace App\Console\Commands;

use App\Jobs\SendMarketingEmailJob;
use App\Jobs\SendMarketingSmsJob;
use App\Models\MarketingDeliveryLog;
use App\Models\MarketingScenario;
use App\Models\MarketingScenarioRun;
use App\Models\User;
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
        $dueScenarios = MarketingScenario::where('is_active', true)->get()->filter(
            fn (MarketingScenario $scenario) => $scenario->isDue(now())
        );

        foreach ($dueScenarios as $scenario) {
            $run = MarketingScenarioRun::create([
                'marketing_scenario_id' => $scenario->id,
                'scheduled_for' => now(),
                'status' => 'processing',
            ]);

            $recipients = User::query()
                ->whereHas('progress', function ($query) {
                    $query->where('is_completed', false);
                })
                ->where('consent_2', true)
                ->whereNotNull('email')
                ->select(['id', 'name', 'email', 'phone', 'consent_2'])
                ->distinct()
                ->get();

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
}
