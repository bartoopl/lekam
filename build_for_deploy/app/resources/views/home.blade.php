<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Strona główna') }}
        </h2>
    </x-slot>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Platforma Szkoleń Farmaceutycznych
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Profesjonalne szkolenia online dla techników farmacji i farmaceutów. 
                    Rozwijaj swoje umiejętności i zdobywaj certyfikaty.
                </p>
                <div class="space-x-4">
                    <a href="{{ route('courses') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Przeglądaj szkolenia
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                            Zarejestruj się
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Dlaczego warto wybrać naszą platformę?
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Oferujemy specjalistyczne szkolenia dostosowane do potrzeb branży farmaceutycznej
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Specjalistyczne kursy</h3>
                    <p class="text-gray-600">Kursy przygotowane przez ekspertów branży farmaceutycznej</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Certyfikaty</h3>
                    <p class="text-gray-600">Otrzymuj oficjalne certyfikaty po ukończeniu szkoleń</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Nauka w swoim tempie</h3>
                    <p class="text-gray-600">Ucz się kiedy chcesz i gdzie chcesz</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Courses -->
    @if($featuredCourses->count() > 0)
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Polecane szkolenia
                    </h2>
                    <p class="text-lg text-gray-600">
                        Sprawdź nasze najpopularniejsze kursy
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredCourses as $course)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2">{{ $course->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 100) }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">{{ $course->difficulty }}</span>
                                    <a href="{{ route('courses.show', $course) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                        Szczegóły
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('courses') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Zobacz wszystkie szkolenia
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- CTA Section -->
    <div class="bg-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">
                Rozpocznij swoją karierę w farmacji
            </h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Dołącz do tysięcy specjalistów, którzy już korzystają z naszej platformy
            </p>
            @guest
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Zarejestruj się teraz
                </a>
            @else
                <a href="{{ route('courses') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Przeglądaj szkolenia
                </a>
            @endguest
        </div>
    </div>
</x-app-layout>
