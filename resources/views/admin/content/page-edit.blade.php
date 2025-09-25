@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold flex items-center">
                <span class="text-4xl mr-3">{{ $pageInfo[$page]['icon'] }}</span>
                Edytuj treści - {{ $pageInfo[$page]['title'] }}
            </h1>
            <p class="text-gray-600">{{ $pageInfo[$page]['description'] }}</p>
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

    <form method="POST" action="{{ route('admin.content.page.update', $page) }}">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            @foreach($contents->groupBy('section') as $sectionName => $sectionContents)
                <div class="bg-white shadow-md rounded-lg">
                    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Sekcja: {{ ucfirst(str_replace('_', ' ', $sectionName)) }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($sectionContents as $content)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                {{ $content->title }}
                                            </label>
                                            <span class="text-xs text-gray-500">Klucz: {{ $content->key }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="hidden" name="contents[{{ $content->id }}][is_active]" value="0">
                                            <input type="checkbox"
                                                   name="contents[{{ $content->id }}][is_active]"
                                                   value="1"
                                                   {{ $content->is_active ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label class="ml-2 text-sm text-gray-700">Aktywna</label>
                                        </div>
                                    </div>

                                    @if($content->type === 'html' || $content->type === 'wysiwyg')
                                        <textarea name="contents[{{ $content->id }}][content]"
                                                  rows="4"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-vertical"
                                                  required>{{ old("contents.{$content->id}.content", $content->content) }}</textarea>
                                        <p class="text-xs text-gray-500 mt-1">Można używać HTML</p>
                                    @else
                                        <textarea name="contents[{{ $content->id }}][content]"
                                                  rows="2"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-vertical"
                                                  required>{{ old("contents.{$content->id}.content", $content->content) }}</textarea>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin.content.index') }}"
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded">
                Anuluj
            </a>
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">
                Zapisz wszystkie zmiany
            </button>
        </div>
    </form>
</div>

<style>
/* Auto-resize textareas */
textarea {
    transition: all 0.2s ease;
}
textarea:focus {
    min-height: 80px;
}
</style>

<script>
// Auto-resize textareas based on content
document.querySelectorAll('textarea').forEach(function(textarea) {
    // Set initial height
    textarea.style.height = 'auto';
    textarea.style.height = Math.max(60, textarea.scrollHeight) + 'px';

    // Resize on input
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.max(60, this.scrollHeight) + 'px';
    });
});
</script>
@endsection