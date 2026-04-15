@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Marketing Automation</h1>
        <a href="{{ route('admin.marketing-automation.create') }}" class="btn btn-primary">Nowy scenariusz</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nazwa</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Scenariusz</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kanał</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Harmonogram</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Akcje</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse($scenarios as $scenario)
                <tr>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-900">{{ $scenario->name }}</div>
                        <div class="text-xs text-gray-500">Utworzył: {{ $scenario->creator?->name ?? 'system' }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        @if($scenario->trigger_type === 'inactive_users')
                            Brak aktywności przez {{ $scenario->inactivity_days }} dni
                        @else
                            Niedokończony kurs przez {{ $scenario->inactivity_days }} dni
                            @if($scenario->targetCourse)
                                <div class="text-xs text-gray-500">{{ $scenario->targetCourse->title }}</div>
                            @endif
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ strtoupper($scenario->channel) }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        {{ $scenario->schedule_type === 'once' ? 'Jednorazowy' : 'Cykliczny' }}
                        @if($scenario->schedule_type === 'recurring')
                            <span class="text-xs text-gray-500">({{ $scenario->recurrence_pattern }} co {{ $scenario->recurrence_interval }})</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($scenario->is_active)
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700">Aktywny</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-700">Nieaktywny</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.marketing-automation.edit', $scenario) }}" class="text-blue-600 hover:text-blue-800">Edytuj</a>
                            <form method="POST" action="{{ route('admin.marketing-automation.toggle', $scenario) }}">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-indigo-800">
                                    {{ $scenario->is_active ? 'Wyłącz' : 'Włącz' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Brak scenariuszy.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mb-8">
        {{ $scenarios->links('pagination::simple-default') }}
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h2 class="font-semibold text-gray-900">Ostatnie logi wysyłek</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Data</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Scenariusz</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Użytkownik</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kanał</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($recentLogs as $log)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $log->scenario?->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $log->user?->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ strtoupper($log->channel) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ strtoupper($log->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Brak logów.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
