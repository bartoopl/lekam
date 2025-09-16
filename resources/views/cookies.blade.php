<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Polityka plików cookies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-8">
                    <h1 class="text-3xl font-bold mb-8">Pliki Cookies - Ciasteczka</h1>

                    <div class="prose max-w-none">
                        <p class="text-lg text-gray-600 mb-8">
                            Stosujemy dwa rodzaje plików Cookies:
                        </p>
                        <ul>
                            <li><strong>sesyjne</strong> – pliki tymczasowe, które pozostają na urządzeniu końcowym Użytkownika aż do wylogowania lub wyłączenia oprogramowania (przeglądarki internetowej),</li>
                            <li><strong>stałe</strong> – pliki, które pozostają na urządzeniu końcowym Użytkownika przez czas określony w parametrach plików Cookies albo do momentu ich ręcznego usunięcia przez Użytkownika.</li>
                        </ul>

                        <h2>Cele stosowania plików Cookies</h2>
                        <p>Pliki Cookies umożliwiają:</p>
                        <ul>
                            <li><strong>utrzymanie stanu sesji po zalogowaniu</strong>, co ułatwia logowanie, automatyczne uzupełnianie formularzy, czy też zapamiętywanie ustawień stron internetowych dokonywanych przez Użytkownika. Użytkownik nie musi na stronie internetowej ponownie wpisywać loginu i hasła;</li>
                            <li><strong>ustawienie funkcji i usług Grupy NeoArt</strong>, co skutkuje w szczególności optymalizacją korzystania ze stron internetowych i funkcjonalności oraz dostosowaniem zawartości stron internetowych i funkcjonalności do preferencji i oczekiwań Użytkownika poprzez zapamiętywanie ustawień wybranych przez niego;</li>
                            <li><strong>wyświetlanie komunikatów promocyjnych i reklam</strong>, które są preferowane i oczekiwane przez Użytkownika;</li>
                            <li><strong>dostosowanie wyświetlanych informacji do lokalizacji Użytkownika</strong>;</li>
                            <li><strong>zdefiniowanie preferencji Użytkowników</strong> stron internetowych zarządzanych przez Grupa NeoArt co wpływa na ich ulepszenie i rozwój. Administrator zbiera anonimowe informacje i przetwarza dane na temat trendów i preferencji, bez identyfikowania danych osobowych poszczególnych Użytkowników.</li>
                        </ul>

                        <p>
                            <strong>Pliki Cookies Zewnętrzne</strong> Administrator wykorzystuje w szczególności w celu automatycznego logowania lub rejestracji w serwisach Grupy NeoArt za pomocą zewnętrznego serwisu internetowego, który udostępnił taką możliwość i został funkcjonalnie powiązany z innymi serwisami, którymi zarządza Grupa NeoArt.
                        </p>

                        <h2>Charakterystyka plików cookies</h2>
                        <p>Pliki cookies czyli tzw. ciasteczka:</p>
                        <ul>
                            <li>są zapisywane w pamięci Twojego urządzenia (komputera, telefonu, itd.)</li>
                            <li>umożliwiają Ci, m.in., korzystanie ze wszystkich funkcji serwisu internetowego</li>
                            <li>nie powodują zmian w ustawieniach Twojego urządzenia</li>
                        </ul>

                        <p>Korzystając z odpowiednich opcji Twojej przeglądarki, w każdej chwili możesz:</p>
                        <ul>
                            <li>usunąć pliki cookies</li>
                            <li>blokować wykorzystanie plików cookies w przyszłości</li>
                        </ul>

                        <h2>Zastosowanie na naszej witrynie</h2>
                        <p>Na naszej witrynie ciasteczka wykorzystywane są w celu:</p>
                        <ul>
                            <li>zapamiętywania informacji o Twojej sesji</li>
                            <li>statystycznym</li>
                            <li>marketingowym</li>
                            <li>udostępniania funkcji serwisu internetowego</li>
                        </ul>

                        <p>
                            Aby dowiedzieć się jak zarządzać plikami cookies, w tym jak wyłączyć ich obsługę w Twojej przeglądarce, możesz skorzystać z pliku pomocy Twojej przeglądarki. Z informacjami na ten temat możesz zapoznać się wciskając klawisz F1 w przeglądarce.
                        </p>

                        <p>
                            <strong>Jeśli nie wyłączysz wykorzystywania plików cookies w ustawieniach przeglądarki, oznacza to, że wyrażasz zgodę na ich wykorzystanie.</strong>
                        </p>

                        <h2>Usługi zewnętrzne/odbiorcy danych</h2>
                        <p>
                            Korzystamy z usług podmiotów zewnętrznych, którym mogą być przekazywane Twoje dane. Poniżej znajduje się lista tych podmiotów:
                        </p>
                        <ul>
                            <li>podmiot realizujący dostawę towarów lub usług</li>
                            <li>podmioty współpracujące z Grupa NeoArt przy realizacji szkoleń, webinariów, transmisji online</li>
                            <li>dostawca płatności</li>
                            <li>biuro księgowe</li>
                            <li>hostingodawca</li>
                            <li>podmiot ułatwiający optymalizację serwisu</li>
                            <li>osoby współpracujące z nami na podstawie umów cywilnoprawnych, wspierające naszą bieżącą działalność</li>
                            <li>dostawca oprogramowania ułatwiającego prowadzenie działalności (np. oprogramowanie księgowe)</li>
                            <li>podmiot zapewniający nam wsparcie techniczne</li>
                            <li>podmiot zapewniający system mailingowy</li>
                            <li>podmiot zapewniający usługi marketingowe i telemarketingowe</li>
                            <li>dostawca oprogramowania potrzebnego do prowadzenia serwisu internetowego</li>
                        </ul>

                        <h2>Kontakt z administratorem</h2>
                        <p>
                            Chcesz skorzystać ze swoich uprawnień dotyczących danych osobowych? A może po prostu chcesz zapytać o coś związanego z naszą Polityką Prywatności? Napisz na adres e-mail: <strong>office@grupaneoart.pl</strong>
                        </p>

                        <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">
                                <strong>Data ostatniej aktualizacji:</strong> {{ date('d.m.Y') }}<br>
                                <strong>Wersja polityki cookies:</strong> 1.0
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>