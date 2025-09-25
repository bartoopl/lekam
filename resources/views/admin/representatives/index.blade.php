@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Przedstawiciele</h1>
            <p class="text-gray-600 mt-1">Zarządzaj przedstawicieilami i kodami QR</p>
        </div>
        <a href="{{ route('admin.representatives.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i>
            Dodaj przedstawiciela
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nazwa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kod</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zarejestrowanych</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($representatives as $representative)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $representative->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $representative->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $representative->phone ?: '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-mono rounded">{{ $representative->code }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-blue-600">{{ $representative->users_count }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($representative->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktywny</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Nieaktywny</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.representatives.show', $representative) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                    <i class="fas fa-eye mr-1"></i>Podgląd
                                </a>
                                <a href="{{ route('admin.representatives.edit', $representative) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                    <i class="fas fa-edit mr-1"></i>Edytuj
                                </a>
                                <form method="POST" action="{{ route('admin.representatives.destroy', $representative) }}" class="inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tego przedstawiciela?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                        <i class="fas fa-trash mr-1"></i>Usuń
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-users text-4xl mb-4"></i>
                                <p>Brak przedstawicieli</p>
                                <a href="{{ route('admin.representatives.create') }}" class="text-blue-600 hover:text-blue-800 underline">
                                    Dodaj pierwszego przedstawiciela
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($representatives->hasPages())
        <div class="mt-6">
            {{ $representatives->links() }}
        </div>
    @endif
</div>
@endsection