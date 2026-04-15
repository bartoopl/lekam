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
        <label class="block text-sm font-medium text-gray-700 mb-1">Typ scenariusza</label>
        <select name="trigger_type" id="trigger_type" class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="incomplete_course" @selected(old('trigger_type', $scenario->trigger_type ?? 'incomplete_course') === 'incomplete_course')>
                Użytkownik w trakcie kursu i nie kończy
            </option>
            <option value="inactive_users" @selected(old('trigger_type', $scenario->trigger_type ?? 'incomplete_course') === 'inactive_users')>
                Użytkownik bez aktywności
            </option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Okres bezczynności (dni)</label>
        <input type="number" min="1" max="365" name="inactivity_days"
               value="{{ old('inactivity_days', $scenario->inactivity_days ?? 7) }}"
               class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
</div>

<div id="target_course_wrapper">
    <label class="block text-sm font-medium text-gray-700 mb-1">Kurs (dla scenariusza niedokończonego kursu)</label>
    <select name="target_course_id" class="w-full border border-gray-300 rounded px-3 py-2">
        <option value="">Wybierz kurs</option>
        @foreach(($courses ?? collect()) as $courseOption)
            <option value="{{ $courseOption->id }}" @selected((string) old('target_course_id', $scenario->target_course_id ?? '') === (string) $courseOption->id)>
                {{ $courseOption->title }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Wymagana zgoda</label>
    <select name="required_consent" class="w-full border border-gray-300 rounded px-3 py-2">
        <option value="consent_1" @selected(old('required_consent', $scenario->required_consent ?? 'consent_2') === 'consent_1')>
            Zgoda 1 (RODO)
        </option>
        <option value="consent_2" @selected(old('required_consent', $scenario->required_consent ?? 'consent_2') === 'consent_2')>
            Zgoda 2 (marketing LEK-AM)
        </option>
        <option value="consent_3" @selected(old('required_consent', $scenario->required_consent ?? 'consent_2') === 'consent_3')>
            Zgoda 3 (marketing NeoArt)
        </option>
    </select>
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
    <textarea id="email_body_editor" name="email_body" rows="8" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('email_body', $scenario->email_body ?? '') }}</textarea>
    <p class="text-xs text-gray-500 mt-1">Obsługuje HTML (logo, obrazki, formatowanie). Możesz wstawić obraz przez URL.</p>
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

<div class="flex items-center gap-2">
    <input id="dry_run" type="checkbox" name="dry_run" value="1" @checked(old('dry_run', $scenario->dry_run ?? true))>
    <label for="dry_run" class="text-sm text-gray-700">Dry-run (bez realnej wysyłki, tylko logi testowe)</label>
</div>

<div class="rounded border border-blue-200 bg-blue-50 p-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h4 class="font-medium text-blue-900">Podgląd odbiorców i terminu wysyłki</h4>
            <p class="text-sm text-blue-700">Sprawdź, kto aktualnie łapie się do scenariusza i kiedy będzie najbliższa wysyłka.</p>
        </div>
        <button type="button" id="previewRecipientsBtn" class="btn btn-primary">Pobierz podgląd</button>
    </div>
    <div id="previewResult" class="mt-3 text-sm text-gray-700"></div>
</div>

<script>
    (function () {
        const form = document.querySelector('form[action*="marketing-automation"]');
        const triggerSelect = document.getElementById('trigger_type');
        const targetCourseWrapper = document.getElementById('target_course_wrapper');
        const previewBtn = document.getElementById('previewRecipientsBtn');
        const previewResult = document.getElementById('previewResult');

        if (!triggerSelect || !targetCourseWrapper || !form) {
            return;
        }

        function toggleTargetCourse() {
            targetCourseWrapper.style.display = triggerSelect.value === 'incomplete_course' ? 'block' : 'none';
        }

        triggerSelect.addEventListener('change', toggleTargetCourse);
        toggleTargetCourse();

        if (previewBtn && previewResult) {
            previewBtn.addEventListener('click', async function () {
                previewBtn.disabled = true;
                previewBtn.textContent = 'Pobieranie...';
                previewResult.innerHTML = '';

                try {
                    if (window.tinymce && window.tinymce.get('email_body_editor')) {
                        window.tinymce.get('email_body_editor').save();
                    }

                    const formData = new FormData(form);
                    const response = await fetch('{{ route('admin.marketing-automation.preview') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData,
                        credentials: 'same-origin',
                    });

                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message || 'Nie udało się pobrać podglądu.');
                    }

                    const rows = (data.sample || []).map((item) => {
                        return `<li>${item.name} (${item.email}${item.phone ? ', ' + item.phone : ''})</li>`;
                    }).join('');
                    previewResult.innerHTML = `
                        <div><strong>Liczba odbiorców teraz:</strong> ${data.count}</div>
                        <div><strong>Najbliższa wysyłka:</strong> ${data.next_dispatch_at || 'brak'}</div>
                        <div class="mt-2"><strong>Próbka odbiorców:</strong></div>
                        <ul class="list-disc pl-5">${rows || '<li>Brak odbiorców</li>'}</ul>
                    `;
                } catch (error) {
                    previewResult.innerHTML = `<div class="text-red-700">${error.message || error}</div>`;
                } finally {
                    previewBtn.disabled = false;
                    previewBtn.textContent = 'Pobierz podgląd';
                }
            });
        }

        const initEditor = function () {
            if (!window.tinymce || window.tinymce.get('email_body_editor')) {
                return;
            }
            window.tinymce.init({
                selector: '#email_body_editor',
                menubar: false,
                height: 320,
                plugins: 'link image lists table code',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code',
            });
        };
        initEditor();
        window.__initMarketingEditor = initEditor;
    })();
</script>
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin" onload="window.__initMarketingEditor && window.__initMarketingEditor()"></script>
