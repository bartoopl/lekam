@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edytuj szablon: {{ $template->name }}
            </h2>
        </div>
    </div>

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form action="{{ route('admin.certificate-templates.update', $template) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column - Basic Info -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-700">Podstawowe informacje</h3>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nazwa</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $template->name) }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="user_type" class="block text-sm font-medium text-gray-700">Typ użytkownika</label>
                                <select name="user_type" id="user_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Wszystkie typy</option>
                                    <option value="farmaceuta" {{ $template->user_type === 'farmaceuta' ? 'selected' : '' }}>Farmaceuta</option>
                                    <option value="technik_farmacji" {{ $template->user_type === 'technik_farmacji' ? 'selected' : '' }}>Technik farmacji</option>
                                </select>
                            </div>

                            <div>
                                <label for="course_id" class="block text-sm font-medium text-gray-700">Kurs</label>
                                <select name="course_id" id="course_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Domyślny (wszystkie kursy)</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ $template->course_id == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="certificate_prefix" class="block text-sm font-medium text-gray-700">Prefix certyfikatu</label>
                                <input type="text" name="certificate_prefix" id="certificate_prefix"
                                       value="{{ old('certificate_prefix', $template->certificate_prefix) }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="next_certificate_number" class="block text-sm font-medium text-gray-700">Następny numer</label>
                                <input type="number" name="next_certificate_number" id="next_certificate_number"
                                       value="{{ old('next_certificate_number', $template->next_certificate_number) }}" min="1"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="pdf_file" class="block text-sm font-medium text-gray-700">Nowy PDF (opcjonalnie)</label>
                                <input type="file" name="pdf_file" id="pdf_file" accept=".pdf"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
                                @if($template->pdf_path)
                                    <p class="mt-1 text-sm text-gray-500">Aktualny: {{ basename($template->pdf_path) }}</p>
                                @endif
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" {{ $template->is_active ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    <span class="ml-2 text-sm text-gray-600">Aktywny</span>
                                </label>
                            </div>
                        </div>

                        <!-- Right Column - Field Positions -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-700">Pozycje pól na certyfikacie</h3>
                            <p class="text-sm text-gray-600">Podaj współrzędne X, Y (w pikselach od lewego górnego rogu) oraz rozmiar czcionki</p>

                            @php
                                $fields = [
                                    'certificate_number' => 'Numer certyfikatu',
                                    'user_name' => 'Imię i nazwisko',
                                    'course_title' => 'Tytuł kursu',
                                    'completion_date' => 'Data ukończenia',
                                    'points' => 'Punkty',
                                    'user_type' => 'Typ użytkownika',
                                    'expiry_date' => 'Data ważności',
                                ];
                                $config = $template->getFieldsConfig();
                            @endphp

                            @foreach($fields as $fieldKey => $fieldLabel)
                                <div class="border border-gray-200 rounded p-3">
                                    <div class="font-medium text-sm text-gray-700 mb-2">{{ $fieldLabel }}</div>
                                    <div class="grid grid-cols-4 gap-2">
                                        <div>
                                            <label class="text-xs text-gray-500">X</label>
                                            <input type="number" name="{{ $fieldKey }}_x" step="0.1"
                                                   value="{{ $config[$fieldKey]['x'] ?? '' }}"
                                                   class="mt-1 block w-full text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-500">Y</label>
                                            <input type="number" name="{{ $fieldKey }}_y" step="0.1"
                                                   value="{{ $config[$fieldKey]['y'] ?? '' }}"
                                                   class="mt-1 block w-full text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-500">Rozmiar</label>
                                            <input type="number" name="{{ $fieldKey }}_font_size"
                                                   value="{{ $config[$fieldKey]['font_size'] ?? 12 }}"
                                                   class="mt-1 block w-full text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-500">Wyrównanie</label>
                                            <select name="{{ $fieldKey }}_align"
                                                    class="mt-1 block w-full text-sm border-gray-300 rounded-md">
                                                <option value="left" {{ ($config[$fieldKey]['align'] ?? 'left') === 'left' ? 'selected' : '' }}>Lewo</option>
                                                <option value="center" {{ ($config[$fieldKey]['align'] ?? '') === 'center' ? 'selected' : '' }}>Środek</option>
                                                <option value="right" {{ ($config[$fieldKey]['align'] ?? '') === 'right' ? 'selected' : '' }}>Prawo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                                <p class="text-xs text-yellow-800">
                                    💡 <strong>Wskazówka:</strong> Użyj edytora PDF lub narzędzia do sprawdzania pozycji.
                                    Współrzędna (0,0) to lewy górny róg. Dla PDF A4 (landscape): szerokość ≈ 842px, wysokość ≈ 595px.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.certificate-templates.index') }}"
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
    </div>
</div>
@endsection
