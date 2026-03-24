<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingDeliveryLog;
use App\Models\MarketingScenario;
use Illuminate\Http\Request;

class MarketingAutomationController extends Controller
{
    public function index()
    {
        $scenarios = MarketingScenario::with('creator')
            ->orderByDesc('created_at')
            ->paginate(15);

        $recentLogs = MarketingDeliveryLog::with(['scenario', 'user'])
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('admin.marketing-automation.index', compact('scenarios', 'recentLogs'));
    }

    public function create()
    {
        return view('admin.marketing-automation.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['created_by'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active');

        MarketingScenario::create($data);

        return redirect()->route('admin.marketing-automation.index')
            ->with('success', 'Scenariusz został utworzony.');
    }

    public function edit(MarketingScenario $scenario)
    {
        return view('admin.marketing-automation.edit', compact('scenario'));
    }

    public function update(Request $request, MarketingScenario $scenario)
    {
        $data = $this->validateData($request);
        $data['is_active'] = $request->boolean('is_active');

        $scenario->update($data);

        return redirect()->route('admin.marketing-automation.index')
            ->with('success', 'Scenariusz został zaktualizowany.');
    }

    public function toggle(MarketingScenario $scenario)
    {
        $scenario->update([
            'is_active' => !$scenario->is_active,
        ]);

        return back()->with('success', 'Status scenariusza został zmieniony.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'channel' => ['required', 'in:email,sms,both'],
            'email_subject' => ['nullable', 'string', 'max:255'],
            'email_body' => ['nullable', 'string'],
            'sms_body' => ['nullable', 'string', 'max:1000'],
            'schedule_type' => ['required', 'in:once,recurring'],
            'start_at' => ['required', 'date'],
            'timezone' => ['required', 'string', 'max:100'],
            'recurrence_pattern' => ['nullable', 'in:daily,weekly,monthly'],
            'recurrence_interval' => ['nullable', 'integer', 'min:1', 'max:365'],
        ]);
    }
}
