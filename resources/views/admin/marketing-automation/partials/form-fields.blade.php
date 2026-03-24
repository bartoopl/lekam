<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Nazwa</label>
    <input type="text" name="name" required
           value="{{ old('name', $scenario->name ?? '') }}"
           class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Opis</label>
    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $scenario->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kanał</label>
        <select name="channel" class="w-full border border-gray-300 rounded px-3 py-2">
            @foreach(['email' => 'Email', 'sms' => 'SMS', 'both' => 'Email + SMS'] as $value => $label)
                <option value="{{ $value }}" @selected(old('channel', $scenario->channel ?? 'both') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Strefa czasu</label>
        <input type="text" name="timezone" value="{{ old('timezone', $scenario->timezone ?? 'Europe/Warsaw') }}" class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Temat email</label>
    <input type="text" name="email_subject"
           value="{{ old('email_subject', $scenario->email_subject ?? '') }}"
           class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Treść email</label>
    <textarea name="email_body" rows="5" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('email_body', $scenario->email_body ?? '') }}</textarea>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Treść SMS</label>
    <textarea name="sms_body" rows="4" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('sms_body', $scenario->sms_body ?? '') }}</textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Typ harmonogramu</label>
        <select name="schedule_type" class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="once" @selected(old('schedule_type', $scenario->schedule_type ?? 'once') === 'once')>Jednorazowy</option>
            <option value="recurring" @selected(old('schedule_type', $scenario->schedule_type ?? 'once') === 'recurring')>Cykliczny</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Start</label>
        <input type="datetime-local" name="start_at"
               value="{{ old('start_at', isset($scenario) ? $scenario->start_at->format('Y-m-d\TH:i') : now()->addHour()->format('Y-m-d\TH:i')) }}"
               class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Powtarzanie</label>
        <select name="recurrence_pattern" class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="">Brak (dla jednorazowego)</option>
            <option value="daily" @selected(old('recurrence_pattern', $scenario->recurrence_pattern ?? '') === 'daily')>Codziennie</option>
            <option value="weekly" @selected(old('recurrence_pattern', $scenario->recurrence_pattern ?? '') === 'weekly')>Co tydzień</option>
            <option value="monthly" @selected(old('recurrence_pattern', $scenario->recurrence_pattern ?? '') === 'monthly')>Co miesiąc</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Interwał</label>
        <input type="number" min="1" max="365" name="recurrence_interval"
               value="{{ old('recurrence_interval', $scenario->recurrence_interval ?? 1) }}"
               class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
</div>

<div class="flex items-center gap-2">
    <input id="is_active" type="checkbox" name="is_active" value="1" @checked(old('is_active', $scenario->is_active ?? false))>
    <label for="is_active" class="text-sm text-gray-700">Aktywny po zapisie</label>
</div>
