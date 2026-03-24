<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketingScenarioRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketing_scenario_id',
        'scheduled_for',
        'dispatched_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
        'dispatched_at' => 'datetime',
    ];

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(MarketingScenario::class, 'marketing_scenario_id');
    }

    public function deliveryLogs(): HasMany
    {
        return $this->hasMany(MarketingDeliveryLog::class, 'marketing_scenario_run_id');
    }
}
