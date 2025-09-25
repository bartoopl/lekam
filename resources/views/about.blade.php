<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('O nas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $contents['about.hero.title']->content ?? 'O Platformie Szkoleń Farmaceutycznych' }}</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ $contents['about.hero.description']->content ?? 'Jesteśmy dedykowaną platformą e-learningową stworzoną specjalnie dla branży farmaceutycznej. Naszym celem jest wspieranie rozwoju zawodowego techników farmacji i farmaceutów.' }}
                </p>
            </div>

            <!-- Mission Section -->
            <div class="bg-white rounded-lg shadow-sm mb-12">
                <div class="p-8">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h2 class="text-3xl font-bold mb-6">{{ $contents['about.mission.title']->content ?? 'Nasza misja' }}</h2>
                            <div class="text-lg text-gray-600">
                                {!! $contents['about.mission.content'] ? nl2br(e($contents['about.mission.content']->content)) : 'Dostarczamy wysokiej jakości szkolenia online, które pozwalają specjalistom branży farmaceutycznej rozwijać swoje umiejętności i zdobywać nową wiedzę w wygodny i efektywny sposób.<br><br>Wierzymy, że ciągłe kształcenie jest kluczem do sukcesu w dynamicznie rozwijającej się branży farmaceutycznej.' !!}
                            </div>
                        </div>
                        <div class="bg-blue-50 p-8 rounded-lg">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-blue-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                <h3 class="text-xl font-semibold mb-2">Innowacyjne podejście</h3>
                                <p class="text-gray-600">Łączymy tradycyjne metody nauczania z nowoczesnymi technologiami</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Values Section -->
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Jakość</h3>
                    <p class="text-gray-600">
                        Wszystkie nasze kursy są przygotowane przez ekspertów branży farmaceutycznej 
                        i regularnie aktualizowane zgodnie z najnowszymi standardami.
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Elastyczność</h3>
                    <p class="text-gray-600">
                        Ucz się w swoim tempie, gdzie i kiedy chcesz. Nasza platforma jest dostępna 24/7 
                        i dostosowuje się do Twoich potrzeb.
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Wsparcie</h3>
                    <p class="text-gray-600">
                        Oferujemy kompleksowe wsparcie dla naszych użytkowników, 
                        pomagając w rozwoju kariery w branży farmaceutycznej.
                    </p>
                </div>
            </div>

            <!-- Team Section -->
            <div class="bg-white rounded-lg shadow-sm mb-12">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-center mb-8">Nasz zespół</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4"></div>
                            <h3 class="text-xl font-semibold mb-2">Dr Anna Kowalska</h3>
                            <p class="text-gray-600 mb-2">Dyrektor ds. Edukacji</p>
                            <p class="text-sm text-gray-500">
                                Farmaceuta z 15-letnim doświadczeniem, specjalista w dziedzinie farmacji klinicznej.
                            </p>
                        </div>

                        <div class="text-center">
                            <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4"></div>
                            <h3 class="text-xl font-semibold mb-2">Mgr Piotr Nowak</h3>
                            <p class="text-gray-600 mb-2">Kierownik ds. Technicznych</p>
                            <p class="text-sm text-gray-500">
                                Technik farmacji z pasją do nowoczesnych technologii i e-learningu.
                            </p>
                        </div>

                        <div class="text-center">
                            <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4"></div>
                            <h3 class="text-xl font-semibold mb-2">Dr Maria Wiśniewska</h3>
                            <p class="text-gray-600 mb-2">Ekspert ds. Zawartości</p>
                            <p class="text-sm text-gray-500">
                                Farmaceuta i wykładowca akademicki specjalizujący się w farmakologii.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg shadow-sm mb-12">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-center mb-8">Nasze osiągnięcia</h2>
                    <div class="grid md:grid-cols-4 gap-8 text-center">
                        <div>
                            <div class="text-3xl font-bold mb-2">1000+</div>
                            <div class="text-blue-100">Zarejestrowanych użytkowników</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-2">50+</div>
                            <div class="text-blue-100">Kursów specjalistycznych</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-2">95%</div>
                            <div class="text-blue-100">Zadowolonych uczestników</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-2">24/7</div>
                            <div class="text-blue-100">Dostępność platformy</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center">
                <h2 class="text-3xl font-bold mb-4">Dołącz do nas</h2>
                <p class="text-lg text-gray-600 mb-8">
                    Rozpocznij swoją podróż z nami i rozwijaj swoje umiejętności w branży farmaceutycznej
                </p>
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Zarejestruj się
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-secondary">
                        Skontaktuj się z nami
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
