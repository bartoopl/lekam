@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Dodaj nową sekcję</h2>
                    <a href="{{ route('admin.courses.show', $course) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Powrót do kursu
                    </a>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Kurs: {{ $course->title }}</h3>
                </div>

                <form method="POST" action="{{ route('admin.chapters.store', $course) }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Tytuł sekcji *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Opis sekcji</label>
                        <textarea name="description" id="description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700">Kolejność *</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $course->chapters()->count() + 1) }}" min="1" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Określa kolejność wyświetlania sekcji w kursie</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.courses.show', $course) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Anuluj
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Utwórz sekcję
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
