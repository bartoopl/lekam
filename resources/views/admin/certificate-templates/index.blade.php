@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Szablony Certyfikatów') }}
            </h2>
            <a href="{{ route('admin.certificate-templates.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Dodaj szablon
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nazwa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Typ użytkownika</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kurs</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prefix</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Następny numer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($templates as $template)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $template->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($template->user_type)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                              {{ $template->user_type === 'farmaceuta' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $template->user_type === 'farmaceuta' ? 'Farmaceuta' : 'Technik' }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">Wszyscy</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($template->course)
                                        {{ Str::limit($template->course->title, 40) }}
                                    @else
                                        <span class="text-gray-500">Domyślny</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $template->certificate_prefix }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $template->next_certificate_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($template->is_active)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Aktywny
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Nieaktywny
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.certificate-templates.edit', $template) }}"
                                       class="text-blue-600 hover:text-blue-900 mr-3">Edytuj</a>
                                    <form action="{{ route('admin.certificate-templates.destroy', $template) }}"
                                          method="POST" class="inline"
                                          onsubmit="return confirm('Czy na pewno chcesz usunąć ten szablon?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Brak szablonów certyfikatów.
                                    <a href="{{ route('admin.certificate-templates.create') }}" class="text-blue-600 hover:text-blue-900">
                                        Dodaj pierwszy szablon
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $templates->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
