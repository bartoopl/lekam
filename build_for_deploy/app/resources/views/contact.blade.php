<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kontakt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Contact Information -->
                        <div>
                            <h2 class="text-2xl font-bold mb-6">Skontaktuj się z nami</h2>
                            <p class="text-gray-600 mb-8">
                                Masz pytania dotyczące naszych szkoleń? Chcesz dowiedzieć się więcej o platformie? 
                                Skontaktuj się z nami - chętnie pomożemy!
                            </p>

                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Email</h3>
                                        <p class="text-gray-600">kontakt@platforma-farmaceutyczna.pl</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="bg-green-100 p-3 rounded-full mr-4">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Telefon</h3>
                                        <p class="text-gray-600">+48 123 456 789</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="bg-purple-100 p-3 rounded-full mr-4">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Adres</h3>
                                        <p class="text-gray-600">
                                            ul. Przykładowa 123<br>
                                            00-000 Warszawa<br>
                                            Polska
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <h3 class="text-lg font-semibold mb-4">Godziny pracy</h3>
                                <div class="space-y-2 text-gray-600">
                                    <div class="flex justify-between">
                                        <span>Poniedziałek - Piątek</span>
                                        <span>8:00 - 18:00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Sobota</span>
                                        <span>9:00 - 14:00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Niedziela</span>
                                        <span>Zamknięte</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Wyślij wiadomość</h3>
                            <form method="POST" action="#" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Imię i nazwisko</label>
                                    <input type="text" name="name" id="name" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" id="email" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Temat</label>
                                    <select name="subject" id="subject" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Wybierz temat</option>
                                        <option value="general">Pytanie ogólne</option>
                                        <option value="technical">Problem techniczny</option>
                                        <option value="course">Pytanie o kurs</option>
                                        <option value="certificate">Certyfikat</option>
                                        <option value="other">Inne</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Wiadomość</label>
                                    <textarea name="message" id="message" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">
                                    Wyślij wiadomość
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
