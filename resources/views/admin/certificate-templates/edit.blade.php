@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Facades\Storage;
@endphp
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

                    <div class="mt-6 flex justify-between items-center">
                        <div>
                            <a href="{{ route('admin.certificate-templates.demo', $template) }}"
                               target="_blank"
                               class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                🔍 Generuj demo certyfikat
                            </a>
                            <p class="text-xs text-gray-500 mt-1">Otworzy się w nowej karcie z przykładowymi danymi</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.certificate-templates.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Anuluj
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Zapisz zmiany
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Live Preview Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">📊 Podgląd live pozycji pól</h3>
                    @if($template->pdf_path && Storage::disk('public')->exists($template->pdf_path))
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-gray-600">Pokaż PDF:</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="show-pdf-toggle" style="width: 40px; height: 20px; cursor: pointer;">
                            </label>
                        </div>
                    @endif
                </div>
                <div class="bg-gray-100 rounded-lg p-4 flex justify-center" style="max-height: 90vh; overflow: auto;">
                    <div id="preview-container" class="relative bg-white border-2 border-gray-300" style="width: 595px; height: 842px; background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDIiIGhlaWdodD0iNDIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MiIgaGVpZ2h0PSI0MiIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAwIDQyIEwgNDIgNDIgTCA0MiAwIiBmaWxsPSJub25lIiBzdHJva2U9IiNlNWU3ZWIiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIgLz48L3N2Zz4='); background-size: 42px 42px;">

                        <!-- PDF Preview (initially hidden) -->
                        @if($template->pdf_path && Storage::disk('public')->exists($template->pdf_path))
                            <iframe
                                id="pdf-preview"
                                src="{{ Storage::url($template->pdf_path) }}"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; opacity: 0; pointer-events: none; transition: opacity 0.3s;">
                            </iframe>
                        @endif

                        <!-- Display PDF name if exists -->
                        @if($template->pdf_path && Storage::disk('public')->exists($template->pdf_path))
                            <div class="absolute top-2 left-2 bg-blue-500 text-white px-3 py-1 rounded text-xs z-10">
                                📄 {{ basename($template->pdf_path) }}
                            </div>
                        @endif

                        <!-- Size indicator -->
                        <div class="absolute bottom-2 right-2 bg-gray-700 text-white px-3 py-1 rounded text-xs z-10">
                            595 × 842 px (A4 Portrait)
                        </div>

                        <!-- Field markers -->
                        <div id="field-markers" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 5;"></div>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-600">
                    <p>💡 Kolorowe punkty pokazują przybliżone pozycje pól na certyfikacie. Rozmiar okręgu odpowiada rozmiarowi czcionki.</p>
                    <p class="mt-1">📝 Zmień wartości X, Y lub rozmiar czcionki powyżej, aby zobaczyć aktualizację pozycji w czasie rzeczywistym.</p>
                    <p class="mt-1">🖼️ Przełącznik "Pokaż PDF" wyświetla szablon w tle (wymaga przeglądarki z obsługą PDF).</p>
                    <p class="mt-1">⚠️ Współrzędne PDF: (0,0) = lewy górny róg. Użyj przycisku "Generuj demo certyfikat" aby zobaczyć finalny wynik.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fields = {
        'certificate_number': { label: 'Numer', color: '#3b82f6' },
        'user_name': { label: 'Imię', color: '#10b981' },
        'course_title': { label: 'Tytuł', color: '#8b5cf6' },
        'completion_date': { label: 'Data ukończenia', color: '#f59e0b' },
        'points': { label: 'Punkty', color: '#ef4444' },
        'user_type': { label: 'Typ', color: '#ec4899' },
        'expiry_date': { label: 'Ważność', color: '#6366f1' },
    };

    function updatePreview() {
        const container = document.getElementById('field-markers');
        container.innerHTML = '';

        Object.keys(fields).forEach(fieldKey => {
            const x = parseFloat(document.querySelector(`input[name="${fieldKey}_x"]`)?.value) || 0;
            const y = parseFloat(document.querySelector(`input[name="${fieldKey}_y"]`)?.value) || 0;
            const fontSize = parseInt(document.querySelector(`input[name="${fieldKey}_font_size"]`)?.value) || 12;
            const align = document.querySelector(`select[name="${fieldKey}_align"]`)?.value || 'left';

            if (x > 0 || y > 0) {
                const marker = document.createElement('div');
                marker.style.position = 'absolute';
                marker.style.left = x + 'px';
                marker.style.top = y + 'px';
                marker.style.width = (fontSize * 1.5) + 'px';
                marker.style.height = (fontSize * 1.5) + 'px';
                marker.style.backgroundColor = fields[fieldKey].color;
                marker.style.borderRadius = '50%';
                marker.style.opacity = '0.6';
                marker.style.border = '2px solid white';
                marker.style.boxShadow = '0 2px 4px rgba(0,0,0,0.3)';
                marker.style.display = 'flex';
                marker.style.alignItems = 'center';
                marker.style.justifyContent = 'center';
                marker.style.fontSize = '10px';
                marker.style.color = 'white';
                marker.style.fontWeight = 'bold';
                marker.style.cursor = 'help';
                marker.title = `${fields[fieldKey].label} (${x}, ${y}) - Font: ${fontSize}px - Align: ${align}`;
                marker.textContent = fields[fieldKey].label.substring(0, 2);

                container.appendChild(marker);
            }
        });
    }

    // Update preview on input change
    document.querySelectorAll('input[type="number"], select').forEach(input => {
        if (input.name.includes('_x') || input.name.includes('_y') ||
            input.name.includes('_font_size') || input.name.includes('_align')) {
            input.addEventListener('input', updatePreview);
            input.addEventListener('change', updatePreview);
        }
    });

    // PDF toggle functionality
    const pdfToggle = document.getElementById('show-pdf-toggle');
    const pdfPreview = document.getElementById('pdf-preview');

    if (pdfToggle && pdfPreview) {
        pdfToggle.addEventListener('change', function() {
            if (this.checked) {
                pdfPreview.style.opacity = '0.4';
            } else {
                pdfPreview.style.opacity = '0';
            }
        });
    }

    // Initial preview
    updatePreview();
});
</script>
@endsection
