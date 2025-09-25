@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Zarządzanie treściami</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($contentStats as $page => $stats)
            <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-3xl mr-3">{{ $stats['info']['icon'] }}</div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $stats['info']['title'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $stats['info']['description'] }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $stats['count'] }}</div>
                            <div class="text-xs text-gray-500">Treści ogółem</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
                            <div class="text-xs text-gray-500">Aktywne</div>
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <a href="{{ route('admin.content.page.edit', $page) }}"
                           class="flex-1 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded text-center transition-colors duration-200">
                            Edytuj stronę
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white shadow-md rounded-lg p-8 text-center">
                    <div class="text-gray-400 text-4xl mb-4">📄</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Brak treści</h3>
                    <p class="text-sm text-gray-600">
                        Uruchom seedera, aby utworzyć domyślne treści dla stron.
                    </p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection