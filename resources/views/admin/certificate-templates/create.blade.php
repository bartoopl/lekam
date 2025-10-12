@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dodaj nowy szablon certyfikatu
            </h2>
        </div>
    </div>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form action="{{ route('admin.certificate-templates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nazwa szablonu</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- User Type -->
                        <div>
                            <label for="user_type" class="block text-sm font-medium text-gray-700">Typ użytkownika</label>
                            <select name="user_type" id="user_type"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Wszystkie typy</option>
                                <option value="farmaceuta" {{ old('user_type') === 'farmaceuta' ? 'selected' : '' }}>Farmaceuta</option>
                                <option value="technik_farmacji" {{ old('user_type') === 'technik_farmacji' ? 'selected' : '' }}>Technik farmacji</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Zostaw puste dla uniwersalnego szablonu</p>
                            @error('user_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Course -->
                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700">Kurs (opcjonalnie)</label>
                            <select name="course_id" id="course_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Domyślny szablon (dla wszystkich kursów)</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Przypisz szablon do konkretnego kursu lub zostaw puste dla szablonu domyślnego</p>
                            @error('course_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- PDF Upload -->
                        <div>
                            <label for="pdf_file" class="block text-sm font-medium text-gray-700">Plik PDF szablonu</label>
                            <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                            <p class="mt-1 text-sm text-gray-500">Wgraj gotowy PDF z podpisami i elementami graficznymi (max 10MB)</p>
                            @error('pdf_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Certificate Prefix -->
                        <div>
                            <label for="certificate_prefix" class="block text-sm font-medium text-gray-700">Prefix numeru certyfikatu</label>
                            <input type="text" name="certificate_prefix" id="certificate_prefix" value="{{ old('certificate_prefix', 'CERT') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Np. FAR dla farmaceutów, TECH dla techników (generuje: FAR/001/2025)</p>
                            @error('certificate_prefix')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Aktywny szablon</span>
                            </label>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <h4 class="font-semibold text-blue-800 mb-2">ℹ️ Ważne</h4>
                            <p class="text-sm text-blue-700">
                                Po utworzeniu szablonu będziesz mógł skonfigurować dokładne pozycje pól (X, Y) w edycji.
                                Domyślnie system użyje standardowych pozycji, które możesz później dostosować do swojego PDF-a.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.certificate-templates.index') }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Anuluj
                        </a>
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Utwórz szablon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
