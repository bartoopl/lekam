@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $representative->name }}</h1>
            <p class="text-gray-600 mt-1">Szczegóły przedstawiciela</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('representatives.edit', $representative) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Edytuj
            </a>
            <a href="{{ route('representatives.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Powrót
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Basic Info -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Informacje podstawowe</h2>
                
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Nazwa:</label>
                        <p class="text-gray-900">{{ $representative->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Email:</label>
                        <p class="text-gray-900">{{ $representative->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Telefon:</label>
                        <p class="text-gray-900">{{ $representative->phone ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Status:</label>
                        @if($representative->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktywny</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Nieaktywny</span>
                        @endif
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Zarejestrowanych użytkowników:</label>
                        <p class="text-2xl font-bold text-blue-600">{{ $representative->users_count }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Code & Links -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Kod QR i link rejestracyjny</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="text-center">
                        <h3 class="text-lg font-medium mb-3">Kod QR</h3>
                        <div class="bg-white p-4 border rounded-lg inline-block">
                            <img src="{{ $representative->qr_code_url }}" alt="QR Code" class="max-w-full">
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Użytkownicy mogą zeskanować ten kod</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium mb-3">Link rejestracyjny</h3>
                        <div class="bg-gray-50 p-3 rounded border">
                            <p class="text-sm font-mono break-all">{{ $representative->registration_url }}</p>
                        </div>
                        <button onclick="copyToClipboard('{{ $representative->registration_url }}')" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                            <i class="fas fa-copy mr-1"></i>Kopiuj link
                        </button>
                        
                        <div class="mt-4">
                            <h4 class="font-medium mb-2">Kod przedstawiciela:</h4>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-2 bg-gray-100 text-gray-800 font-mono rounded">{{ $representative->code }}</span>
                                <form method="POST" action="{{ route('representatives.generate-code', $representative) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white text-sm px-3 py-1 rounded" onclick="return confirm('Czy na pewno chcesz wygenerować nowy kod? Stary kod przestanie działać.')">
                                        <i class="fas fa-refresh mr-1"></i>Wygeneruj nowy
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Ostatnio zarejestrowani użytkownicy</h2>
                
                @if($representative->users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Imię</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Typ</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Data rejestracji</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($representative->users as $user)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $user->email }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                                                {{ ucfirst($user->user_type) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($representative->users_count > 10)
                        <p class="text-sm text-gray-600 mt-3 text-center">
                            Pokazano 10 z {{ $representative->users_count }} użytkowników
                        </p>
                    @endif
                @else
                    <p class="text-gray-500 text-center py-8">Brak zarejestrowanych użytkowników</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link został skopiowany do schowka!');
    }).catch(function(err) {
        console.error('Błąd kopiowania: ', err);
    });
}
</script>
@endsection