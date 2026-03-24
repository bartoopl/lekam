<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketingDeliveryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketing_scenario_id',
        'marketing_scenario_run_id',
        'user_id',
        'channel',
        'status',
        'provider_message_id',
        'error_message',
        'sent_at',
        'meta',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'meta' => 'array',
    ];

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(MarketingScenario::class, 'marketing_scenario_id');
    }

    public function run(): BelongsTo
    {
        return $this->belongsTo(MarketingScenarioRun::class, 'marketing_scenario_run_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
