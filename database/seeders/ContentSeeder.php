<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Content;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // Strona główna (welcome.blade.php)
            [
                'key' => 'home.hero.title.desktop',
                'title' => 'Główny tytuł na desktop',
                'content' => 'Akademia LEK-AM<br>Lepsza strona farmacji.',
                'type' => 'html',
                'page' => 'home',
                'section' => 'hero',
            ],
            [
                'key' => 'home.hero.title.mobile',
                'title' => 'Główny tytuł na mobile',
                'content' => 'Akademia<br>LEK-AM<br>Lepsza strona farmacji.',
                'type' => 'html',
                'page' => 'home',
                'section' => 'hero',
            ],
            [
                'key' => 'home.hero.description',
                'title' => 'Opis w sekcji hero',
                'content' => '<b>Witaj w serwisie stworzonym z myślą o farmaceutach i technikach farmacji.</b> To wymagające zawody – nie tylko ze względu na codzienną pracę w aptece, ale także przez wpisaną w nie potrzebę stałego rozwoju. Akademia LEK-AM wspiera Cię w tym procesie. Zarejestruj konto, aby zyskać dostęp do bezpłatnych szkoleń, zdobywać punkty edukacyjne i poszerzać wiedzę – bez wychodzenia z domu.',
                'type' => 'html',
                'page' => 'home',
                'section' => 'hero',
            ],
            [
                'key' => 'home.about.title',
                'title' => 'Tytuł sekcji O Akademii',
                'content' => 'Farmacja. Wiedza. Rozwój. Zdalnie. Prosto. Efektywnie. Akademia. Zapisz się na przyszłość.',
                'type' => 'text',
                'page' => 'home',
                'section' => 'about',
            ],
            [
                'key' => 'home.features.title',
                'title' => 'Tytuł sekcji Nasza idea',
                'content' => 'Nasza idea - wiedzieć więcej',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.features.description',
                'title' => 'Opis naszej idei',
                'content' => 'Sama idea akademii sięga starożytności – to tam, w gaju Akademosa, narodziła się wspólnota nauki i myśli. Dziś, w nowoczesnej formule, Akademia LEK-AM kontynuuje tego ducha: jako przestrzeń dla tych, którzy chcą rozwijać się świadomie, odpowiedzialnie i w zgodzie z wymaganiami współczesnej farmacji.',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.trainings.title',
                'title' => 'Tytuł sekcji Szkolenia',
                'content' => 'Nowoczesna edukacja online. Profesjonalnie, wygodnie, skutecznie.',
                'type' => 'text',
                'page' => 'home',
                'section' => 'trainings',
            ],
            [
                'key' => 'home.trainings.description',
                'title' => 'Opis sekcji Szkolenia',
                'content' => 'W Akademii LEK-AM szkolisz się wtedy, gdy Ci wygodnie – bez grafiku, dojazdów i formalności. Wybierasz interesujący Cię temat, oglądasz wykład prowadzony przez eksperta, rozwiązujesz test i pobierasz certyfikat – wszystko w intuicyjnym systemie online.\nTreści są merytoryczne, zawsze zgodne z aktualną wiedzą, a zajęcia prowadzone przez renomowanych wykładowców, specjalistów w danej dziedzinie. To rozwiązanie stworzone z myślą o farmaceutach i technikach farmacji, którzy cenią jakość, prostotę i efektywność.',
                'type' => 'html',
                'page' => 'home',
                'section' => 'trainings',
            ],

            // Strona Szkolenia (courses.blade.php)
            [
                'key' => 'courses.hero.title',
                'title' => 'Tytuł strony Szkolenia',
                'content' => 'Szkolenia',
                'type' => 'text',
                'page' => 'courses',
                'section' => 'hero',
            ],
            [
                'key' => 'courses.hero.description',
                'title' => 'Opis strony Szkolenia',
                'content' => 'Szkolenia Akademii Lek‑am zostały przygotowane z najwyższą dbałością jeśli chodzi o wartość merytoryczną, są zawsze zgodne z aktualnymi standardami i wymaganiami współczesnej farmacji. Prowadzą je renomowani wykładowcy i eksperci z wieloletnim doświadczeniem. Nasza oferta obejmuje starannie opracowane kursy, które wspierają rozwój zawodowy farmaceutów i techników farmacji, łącząc rzetelną wiedzę z praktycznym podejściem do codziennej pracy.',
                'type' => 'text',
                'page' => 'courses',
                'section' => 'hero',
            ],

            // Strona Kontakt
            [
                'key' => 'contact.intro.text1',
                'title' => 'Pierwszy akapit na stronie kontakt',
                'content' => 'Masz pytania dotyczące naszych kursów? Skontaktuj się z nami, aby uzyskać szczegółowe informacje o szkoleniach, zapisach i punktach edukacyjnych.',
                'type' => 'text',
                'page' => 'contact',
                'section' => 'intro',
            ],
            [
                'key' => 'contact.intro.text2',
                'title' => 'Drugi akapit na stronie kontakt',
                'content' => 'Możesz też porozmawiać ze swoim przedstawicielem firmy Lek‑am, który udzieli Ci potrzebnych informacji i udzieli wsparcia w korzystaniu z serwisu.',
                'type' => 'text',
                'page' => 'contact',
                'section' => 'intro',
            ],
            [
                'key' => 'contact.lekam.title',
                'title' => 'Tytuł sekcji kontakt LEK-AM',
                'content' => 'Informacja LEK-AM',
                'type' => 'text',
                'page' => 'contact',
                'section' => 'lekam',
            ],
            [
                'key' => 'contact.lekam.phone',
                'title' => 'Telefon LEK-AM',
                'content' => '888 888 888',
                'type' => 'text',
                'page' => 'contact',
                'section' => 'lekam',
            ],
            [
                'key' => 'contact.lekam.email',
                'title' => 'Email LEK-AM',
                'content' => 'info@info.pl',
                'type' => 'text',
                'page' => 'contact',
                'section' => 'lekam',
            ],
            [
                'key' => 'contact.support.title',
                'title' => 'Tytuł sekcji wsparcia technicznego',
                'content' => 'Wsparcie techniczne serwisu',
                'type' => 'text',
                'page' => 'contact',
                'section' => 'support',
            ],
            [
                'key' => 'contact.support.email',
                'title' => 'Email wsparcia technicznego',
                'content' => 'office@creativetrust.pl',
                'type' => 'text',
                'page' => 'contact',
                'section' => 'support',
            ],
        ];

        foreach ($contents as $content) {
            Content::updateOrCreate(
                ['key' => $content['key']],
                $content
            );
        }
    }
}
