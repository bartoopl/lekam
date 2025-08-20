@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dodaj przedstawiciela</h1>
            <p class="text-gray-600 mt-1">Stwórz nowego przedstawiciela z kodem QR</p>
        </div>
        <a href="{{ route('admin.representatives.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Powrót
        </a>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.representatives.store') }}">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nazwa przedstawiciela *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Telefon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex">
                            <i class="fas fa-info-circle text-blue-400 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-blue-800 font-medium">Informacja</h4>
                                <p class="text-blue-700 text-sm mt-1">
                                    Po utworzeniu przedstawiciela zostanie automatycznie wygenerowany unikalny kod rejestracyjny oraz kod QR. 
                                    Przedstawiciel będzie mógł udostępniać link lub kod QR potencjalnym użytkownikom.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.representatives.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded-lg">
                            Anuluj
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                            <i class="fas fa-save mr-2"></i>Utwórz przedstawiciela
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection