<?php

namespace App\Services;

use App\Models\MarketingScenario;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class MarketingRecipientResolver
{
    public function resolve(MarketingScenario $scenario): Collection
    {
        $inactiveSince = now()->subDays(max(1, (int) $scenario->inactivity_days));

        $baseQuery = User::query()
            ->where('consent_2', true)
            ->whereNotNull('email')
            ->select(['id', 'name', 'email', 'phone', 'consent_2'])
            ->distinct();

        if ($scenario->trigger_type === 'inactive_users') {
            return $baseQuery
                ->where('updated_at', '<=', $inactiveSince)
                ->get();
        }

        if ((int) $scenario->target_course_id <= 0) {
            return new Collection();
        }

        return $baseQuery
            ->whereHas('progress', function ($query) use ($scenario, $inactiveSince) {
                $query->where('course_id', $scenario->target_course_id)
                    ->where('is_completed', false)
                    ->where('updated_at', '<=', $inactiveSince);
            })
            ->whereDoesntHave('certificates', function ($query) use ($scenario) {
                $query->where('course_id', $scenario->target_course_id);
            })
            ->get();
    }

    public function count(MarketingScenario $scenario): int
    {
        return $this->resolve($scenario)->count();
    }
}
