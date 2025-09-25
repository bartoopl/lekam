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
            // Strona główna
            [
                'key' => 'home.hero.title',
                'title' => 'Główny tytuł na stronie głównej',
                'content' => 'Platforma Szkoleń Farmaceutycznych',
                'type' => 'text',
                'page' => 'home',
                'section' => 'hero',
            ],
            [
                'key' => 'home.hero.subtitle',
                'title' => 'Podtytuł na stronie głównej',
                'content' => 'Profesjonalne szkolenia online dla techników farmacji i farmaceutów. Rozwijaj swoje umiejętności i zdobywaj certyfikaty.',
                'type' => 'text',
                'page' => 'home',
                'section' => 'hero',
            ],
            [
                'key' => 'home.features.title',
                'title' => 'Tytuł sekcji funkcji',
                'content' => 'Dlaczego warto wybrać naszą platformę?',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.features.subtitle',
                'title' => 'Podtytuł sekcji funkcji',
                'content' => 'Oferujemy specjalistyczne szkolenia dostosowane do potrzeb branży farmaceutycznej',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.features.feature1.title',
                'title' => 'Tytuł pierwszej funkcji',
                'content' => 'Specjalistyczne kursy',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.features.feature1.description',
                'title' => 'Opis pierwszej funkcji',
                'content' => 'Kursy przygotowane przez ekspertów branży farmaceutycznej',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.features.feature2.title',
                'title' => 'Tytuł drugiej funkcji',
                'content' => 'Certyfikaty',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.features.feature2.description',
                'title' => 'Opis drugiej funkcji',
                'content' => 'Otrzymuj oficjalne certyfikaty po ukończeniu szkoleń',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.features.feature3.title',
                'title' => 'Tytuł trzeciej funkcji',
                'content' => 'Nauka w swoim tempie',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.features.feature3.description',
                'title' => 'Opis trzeciej funkcji',
                'content' => 'Ucz się kiedy chcesz i gdzie chcesz',
                'type' => 'text',
                'page' => 'home',
                'section' => 'features',
            ],
            [
                'key' => 'home.cta.title',
                'title' => 'Tytuł sekcji CTA',
                'content' => 'Rozpocznij swoją karierę w farmacji',
                'type' => 'text',
                'page' => 'home',
                'section' => 'cta',
            ],
            [
                'key' => 'home.cta.subtitle',
                'title' => 'Podtytuł sekcji CTA',
                'content' => 'Dołącz do tysięcy specjalistów, którzy już korzystają z naszej platformy',
                'type' => 'text',
                'page' => 'home',
                'section' => 'cta',
            ],

            // Strona O nas
            [
                'key' => 'about.hero.title',
                'title' => 'Główny tytuł strony O nas',
                'content' => 'O Platformie Szkoleń Farmaceutycznych',
                'type' => 'text',
                'page' => 'about',
                'section' => 'hero',
            ],
            [
                'key' => 'about.hero.description',
                'title' => 'Opis na górze strony O nas',
                'content' => 'Jesteśmy dedykowaną platformą e-learningową stworzoną specjalnie dla branży farmaceutycznej. Naszym celem jest wspieranie rozwoju zawodowego techników farmacji i farmaceutów.',
                'type' => 'text',
                'page' => 'about',
                'section' => 'hero',
            ],
            [
                'key' => 'about.mission.title',
                'title' => 'Tytuł sekcji Misja',
                'content' => 'Nasza misja',
                'type' => 'text',
                'page' => 'about',
                'section' => 'mission',
            ],
            [
                'key' => 'about.mission.content',
                'title' => 'Treść sekcji Misja',
                'content' => 'Dostarczamy wysokiej jakości szkolenia online, które pozwalają specjalistom branży farmaceutycznej rozwijać swoje umiejętności i zdobywać nową wiedzę w wygodny i efektywny sposób.\n\nWierzymy, że ciągłe kształcenie jest kluczem do sukcesu w dynamicznie rozwijającej się branży farmaceutycznej.',
                'type' => 'html',
                'page' => 'about',
                'section' => 'mission',
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
