<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\MarketingDeliveryLog;
use App\Models\MarketingScenario;
use App\Services\MarketingRecipientResolver;
use App\Services\SmsApiService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class MarketingAutomationController extends Controller
{
    public function index()
    {
        $scenarios = MarketingScenario::with(['creator', 'targetCourse'])
            ->orderByDesc('created_at')
            ->paginate(15);
        $resolver = app(MarketingRecipientResolver::class);
        foreach ($scenarios as $scenario) {
            $scenario->estimated_recipients = $resolver->count($scenario);
        }

        $recentLogs = MarketingDeliveryLog::with(['scenario', 'user'])
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('admin.marketing-automation.index', compact('scenarios', 'recentLogs'));
    }

    public function create()
    {
        $courses = Course::orderBy('title')->get(['id', 'title']);

        return view('admin.marketing-automation.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['created_by'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active');
        $data['dry_run'] = $request->boolean('dry_run', true);

        MarketingScenario::create($data);

        return redirect()->route('admin.marketing-automation.index')
            ->with('success', 'Scenariusz został utworzony.');
    }

    public function edit(MarketingScenario $scenario)
    {
        $courses = Course::orderBy('title')->get(['id', 'title']);

        return view('admin.marketing-automation.edit', compact('scenario', 'courses'));
    }

    public function update(Request $request, MarketingScenario $scenario)
    {
        $data = $this->validateData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['dry_run'] = $request->boolean('dry_run', true);

        $scenario->update($data);

        return redirect()->route('admin.marketing-automation.index')
            ->with('success', 'Scenariusz został zaktualizowany.');
    }

    public function toggle(MarketingScenario $scenario)
    {
        $isActivating = !$scenario->is_active;
        if ($isActivating) {
            $estimatedRecipients = app(MarketingRecipientResolver::class)->count($scenario);
            if ($estimatedRecipients === 0) {
                return back()->with('error', 'Scenariusz nie został aktywowany: brak odbiorców dla aktualnych reguł.');
            }
        }

        $scenario->update([
            'is_active' => $isActivating,
        ]);

        return back()->with('success', 'Status scenariusza został zmieniony.');
    }

    public function sendTestSms(Request $request, SmsApiService $smsApiService)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:32'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $phone = $this->normalizePhoneNumber($validated['phone']);
        if ($phone === null) {
            throw ValidationException::withMessages([
                'phone' => 'Podaj poprawny numer telefonu (np. +48500100200 lub 500100200).',
            ]);
        }

        try {
            $response = $smsApiService->send($phone, $validated['message']);

            return back()->with('success', 'Testowy SMS wysłany na ' . $phone . '. ID: ' . ($response['provider_message_id'] ?? 'brak'));
        } catch (Throwable $e) {
            \Log::error('SMS test send failed', [
                'phone' => $phone,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return back()->withInput()->with('error', 'Nie udało się wysłać SMS testowego: ' . $e->getMessage());
        }
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'trigger_type' => ['required', 'in:inactive_users,incomplete_course'],
            'inactivity_days' => ['required', 'integer', 'min:1', 'max:365'],
            'target_course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'required_consent' => ['required', 'in:consent_1,consent_2,consent_3'],
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

        if (($validated['trigger_type'] ?? null) === 'incomplete_course' && empty($validated['target_course_id'])) {
            throw ValidationException::withMessages([
                'target_course_id' => 'Wybór kursu jest wymagany dla scenariusza niedokończonego kursu.',
            ]);
        }

        if (($validated['trigger_type'] ?? null) === 'inactive_users') {
            $validated['target_course_id'] = null;
        }

        return $validated;
    }

    private function normalizePhoneNumber(string $phone): ?string
    {
        $clean = preg_replace('/[^\d+]/', '', trim($phone));
        if (!$clean) {
            return null;
        }

        if (str_starts_with($clean, '00')) {
            $clean = '+' . substr($clean, 2);
        }

        if (!str_starts_with($clean, '+')) {
            if (preg_match('/^\d{9}$/', $clean)) {
                $clean = '+48' . $clean;
            } else {
                return null;
            }
        }

        return preg_match('/^\+\d{8,15}$/', $clean) ? $clean : null;
    }
}
