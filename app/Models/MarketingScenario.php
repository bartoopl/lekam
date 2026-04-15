<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketingScenario extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'trigger_type',
        'inactivity_days',
        'target_course_id',
        'required_consent',
        'channel',
        'email_subject',
        'email_body',
        'sms_body',
        'schedule_type',
        'start_at',
        'timezone',
        'recurrence_pattern',
        'recurrence_interval',
        'last_dispatched_at',
        'is_active',
        'dry_run',
        'created_by',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'last_dispatched_at' => 'datetime',
        'inactivity_days' => 'integer',
        'target_course_id' => 'integer',
        'is_active' => 'boolean',
        'dry_run' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function targetCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'target_course_id');
    }

    public function runs(): HasMany
    {
        return $this->hasMany(MarketingScenarioRun::class);
    }

    public function deliveryLogs(): HasMany
    {
        return $this->hasMany(MarketingDeliveryLog::class);
    }

    public function isDue(Carbon $now): bool
    {
        $tzNow = $now->copy()->setTimezone($this->timezone ?: 'Europe/Warsaw');
        $start = $this->start_at->copy()->setTimezone($this->timezone ?: 'Europe/Warsaw');

        if ($tzNow->lt($start)) {
            return false;
        }

        if ($this->schedule_type === 'once') {
            return $this->last_dispatched_at === null;
        }

        $base = $this->last_dispatched_at
            ? $this->last_dispatched_at->copy()->setTimezone($this->timezone ?: 'Europe/Warsaw')
            : $start;

        $interval = max(1, (int) $this->recurrence_interval);
        $next = match ($this->recurrence_pattern) {
            'weekly' => $base->addWeeks($interval),
            'monthly' => $base->addMonths($interval),
            default => $base->addDays($interval),
        };

        return $tzNow->greaterThanOrEqualTo($next);
    }

    public function nextDispatchAt(CarbonInterface $now): ?Carbon
    {
        $timezone = $this->timezone ?: 'Europe/Warsaw';
        $tzNow = Carbon::instance($now)->setTimezone($timezone);
        $start = $this->start_at->copy()->setTimezone($timezone);

        if ($this->schedule_type === 'once') {
            if ($this->last_dispatched_at !== null) {
                return null;
            }

            return $start->greaterThan($tzNow) ? $start : $tzNow;
        }

        $interval = max(1, (int) $this->recurrence_interval);
        $next = $this->last_dispatched_at
            ? $this->last_dispatched_at->copy()->setTimezone($timezone)
            : $start;

        if ($next->greaterThan($tzNow)) {
            return $next;
        }

        $safety = 0;
        while ($next->lessThan($tzNow) && $safety < 1000) {
            $next = match ($this->recurrence_pattern) {
                'weekly' => $next->addWeeks($interval),
                'monthly' => $next->addMonths($interval),
                default => $next->addDays($interval),
            };
            $safety++;
        }

        return $next;
    }

    public function requiredConsentColumn(): string
    {
        return in_array($this->required_consent, ['consent_1', 'consent_2', 'consent_3'], true)
            ? $this->required_consent
            : 'consent_2';
    }
}
