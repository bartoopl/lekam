<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Moje certyfikaty') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Lista wszystkich otrzymanych certyfikatów ukończenia kursów.') }}
        </p>
    </header>

    <div class="mt-6">
        @php
            $certificates = Auth::user()->certificates()->with('course')->orderBy('issued_at', 'desc')->get();
        @endphp

        @if($certificates->count() > 0)
            <div class="space-y-4">
                @foreach($certificates as $certificate)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ $certificate->course->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    Wystawiony: {{ $certificate->issued_at->format('d.m.Y H:i') }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    Nr certyfikatu: {{ $certificate->certificate_number }}
                                </p>
                                @if($certificate->expires_at)
                                    <p class="text-xs text-gray-400">
                                        Ważny do: {{ $certificate->expires_at->format('d.m.Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('certificates.download', $certificate) }}" 
                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Pobierz
                            </a>
                            <a href="{{ route('certificates.show', $certificate) }}" 
                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Podgląd
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-900 mb-2">Brak certyfikatów</h3>
                <p class="text-sm text-gray-500">Ukończ kurs i zdaj test, aby otrzymać certyfikat.</p>
            </div>
        @endif
    </div>
</section>