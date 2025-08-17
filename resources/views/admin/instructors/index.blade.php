@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Zarządzanie Wykładowcami') }}
            </h2>
            <a href="{{ route('admin.instructors.create') }}" class="btn btn-primary">
                Dodaj wykładowcę
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($instructors->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($instructors as $instructor)
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <img src="{{ $instructor->photo_url }}" alt="{{ $instructor->name }}" 
                                             class="w-16 h-16 rounded-full object-cover">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $instructor->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $instructor->email }}</p>
                                            @if($instructor->specialization)
                                                <p class="text-sm text-blue-600">{{ $instructor->specialization }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($instructor->bio)
                                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($instructor->bio, 100) }}</p>
                                    @endif
                                    
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span>{{ $instructor->lessons->count() }} lekcji</span>
                                        <span class="px-2 py-1 rounded-full {{ $instructor->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $instructor->is_active ? 'Aktywny' : 'Nieaktywny' }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.instructors.show', $instructor) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                            Podgląd
                                        </a>
                                        <a href="{{ route('admin.instructors.edit', $instructor) }}" class="text-green-600 hover:text-green-900 text-sm">
                                            Edytuj
                                        </a>
                                        <form action="{{ route('admin.instructors.destroy', $instructor) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Czy na pewno chcesz usunąć tego wykładowcę?')">
                                                Usuń
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $instructors->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak wykładowców</h3>
                            <p class="mt-1 text-sm text-gray-500">Nie ma jeszcze żadnych wykładowców w systemie.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.instructors.create') }}" class="btn btn-primary">
                                    Dodaj pierwszego wykładowcę
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
