<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Moje certyfikaty') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Moje certyfikaty</h1>
                <p class="text-lg text-gray-600">
                    Lista wszystkich certyfikatów, które otrzymałeś po ukończeniu szkoleń
                </p>
            </div>

            @if($certificates->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($certificates as $certificate)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-300">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $certificate->course->title }}</h3>
                                            <p class="text-sm text-gray-500">{{ $certificate->certificate_number }}</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($certificate->getStatus() === 'valid') bg-green-100 text-green-800
                                        @elseif($certificate->getStatus() === 'expired') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($certificate->getStatus()) }}
                                    </span>
                                </div>

                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Wydany:</span>
                                        <span class="font-medium">{{ $certificate->issued_at->format('d.m.Y') }}</span>
                                    </div>
                                    @if($certificate->expires_at)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Ważny do:</span>
                                            <span class="font-medium {{ $certificate->isExpired() ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $certificate->expires_at->format('d.m.Y') }}
                                            </span>
                                        </div>
                                    @endif
                                    @if($certificate->quizAttempt)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Wynik testu:</span>
                                            <span class="font-medium">{{ $certificate->quizAttempt->percentage }}%</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <a href="{{ route('certificates.show', $certificate) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        Zobacz szczegóły
                                    </a>
                                    <a href="{{ route('certificates.download', $certificate) }}" 
                                       class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition duration-300">
                                        Pobierz PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $certificates->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Brak certyfikatów</h3>
                    <p class="text-gray-600 mb-6">
                        Nie masz jeszcze żadnych certyfikatów. Ukończ szkolenia i zdaj testy, aby otrzymać certyfikaty.
                    </p>
                    <a href="{{ route('courses') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Przeglądaj szkolenia
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
