<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Certyfikat - {{ $certificate->course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Certificate Header -->
            <div class="bg-white rounded-lg shadow-sm mb-8">
                <div class="p-8 text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Certyfikat ukończenia</h1>
                    <p class="text-xl text-gray-600 mb-6">{{ $certificate->course->title }}</p>
                    
                    <div class="flex items-center justify-center space-x-4 mb-8">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($certificate->getStatus() === 'valid') bg-green-100 text-green-800
                            @elseif($certificate->getStatus() === 'expired') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($certificate->getStatus()) }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $certificate->certificate_number }}</span>
                    </div>

                    <div class="flex items-center justify-center space-x-6">
                        <a href="{{ route('certificates.download', $certificate) }}" 
                           class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                            Pobierz PDF
                        </a>
                        <a href="{{ route('certificates.index') }}" 
                           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300">
                            Powrót do listy
                        </a>
                    </div>
                </div>
            </div>

            <!-- Certificate Details -->
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Course Information -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold">Informacje o kursie</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nazwa kursu:</span>
                            <span class="font-medium">{{ $certificate->course->title }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Poziom trudności:</span>
                            <span class="font-medium">{{ ucfirst($certificate->course->difficulty) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Liczba lekcji:</span>
                            <span class="font-medium">{{ $certificate->course->lessons->count() }}</span>
                        </div>
                        @if($certificate->course->duration_minutes > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Czas trwania:</span>
                                <span class="font-medium">{{ $certificate->course->duration_minutes }} min</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- User Information -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold">Informacje o uczestniku</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Imię i nazwisko:</span>
                            <span class="font-medium">{{ $certificate->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium">{{ $certificate->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Typ użytkownika:</span>
                            <span class="font-medium">
                                @if($certificate->user->isPharmacist())
                                    Farmaceuta
                                @else
                                    Technik farmacji
                                @endif
                            </span>
                        </div>
                        @if($certificate->user->license_number)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Numer licencji:</span>
                                <span class="font-medium">{{ $certificate->user->license_number }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Certificate Information -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold">Informacje o certyfikacie</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Numer certyfikatu:</span>
                            <span class="font-medium">{{ $certificate->certificate_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Data wydania:</span>
                            <span class="font-medium">{{ $certificate->issued_at->format('d.m.Y H:i') }}</span>
                        </div>
                        @if($certificate->expires_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ważny do:</span>
                                <span class="font-medium {{ $certificate->isExpired() ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $certificate->expires_at->format('d.m.Y') }}
                                </span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium {{ $certificate->getStatus() === 'valid' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($certificate->getStatus()) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quiz Results -->
                @if($certificate->quizAttempt)
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold">Wyniki testu</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Wynik:</span>
                                <span class="font-medium">{{ $certificate->quizAttempt->score }}/{{ $certificate->quizAttempt->max_score }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Procent:</span>
                                <span class="font-medium {{ $certificate->quizAttempt->passed ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $certificate->quizAttempt->percentage }}%
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium {{ $certificate->quizAttempt->passed ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $certificate->quizAttempt->passed ? 'Zaliczony' : 'Nie zaliczony' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Data testu:</span>
                                <span class="font-medium">{{ $certificate->quizAttempt->completed_at->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Certificate Preview -->
            <div class="mt-8 bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Podgląd certyfikatu</h3>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-600 mb-4">Podgląd certyfikatu w formacie PDF</p>
                        <a href="{{ route('certificates.download', $certificate) }}" 
                           class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                            Pobierz certyfikat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
