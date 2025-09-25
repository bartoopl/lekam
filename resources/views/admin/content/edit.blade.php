@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">Edytuj treść</h1>
            <p class="text-gray-600">{{ $content->page }} › {{ $content->section }}</p>
        </div>
        <a href="{{ route('admin.content.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Powrót
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg">
        <form method="POST" action="{{ route('admin.content.update', $content) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="page" class="block text-sm font-medium text-gray-700 mb-2">
                        Strona
                    </label>
                    <input type="text" id="page" value="{{ $content->page }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                </div>

                <div>
                    <label for="section" class="block text-sm font-medium text-gray-700 mb-2">
                        Sekcja
                    </label>
                    <input type="text" id="section" value="{{ $content->section }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                </div>
            </div>

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Tytuł sekcji *
                </label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $content->title) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                <p class="text-xs text-gray-500 mt-1">Nazwa wyświetlana w panelu administratora</p>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Treść *
                </label>
                @if($content->type === 'html' || $content->type === 'wysiwyg')
                    <textarea name="content" id="content" rows="10"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              required>{{ old('content', $content->content) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Można używać HTML</p>
                @else
                    <textarea name="content" id="content" rows="6"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              required>{{ old('content', $content->content) }}</textarea>
                @endif
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $content->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Aktywna treść
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-1">Wyłącz, aby ukryć treść na stronie</p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.content.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Anuluj
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Zapisz zmiany
                </button>
            </div>
        </form>
    </div>
</div>
@endsection