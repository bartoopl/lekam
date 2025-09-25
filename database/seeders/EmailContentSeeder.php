<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Content;

class EmailContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emailContents = [
            // Email weryfikacyjny
            [
                'key' => 'emails.verification.subject',
                'title' => 'Temat emaila weryfikacyjnego',
                'content' => 'Potwierdź swój adres email - Lekam Akademia',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'verification',
            ],
            [
                'key' => 'emails.verification.greeting',
                'title' => 'Powitanie w emailu weryfikacyjnym',
                'content' => 'Cześć!',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'verification',
            ],
            [
                'key' => 'emails.verification.intro',
                'title' => 'Treść wprowadzająca email weryfikacyjny',
                'content' => 'Dziękujemy za rejestrację w Akademii Lekam! Aby rozpocząć naukę i zdobywać punkty edukacyjne, potwierdź swój adres email klikając poniższy przycisk.',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'verification',
            ],
            [
                'key' => 'emails.verification.button_text',
                'title' => 'Tekst przycisku weryfikacji',
                'content' => 'Potwierdź adres email',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'verification',
            ],
            [
                'key' => 'emails.verification.footer',
                'title' => 'Stopka emaila weryfikacyjnego',
                'content' => 'Jeśli nie zarejestrowałeś się w naszej akademii, zignoruj tę wiadomość.',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'verification',
            ],
            [
                'key' => 'emails.verification.signature',
                'title' => 'Podpis emaila weryfikacyjnego',
                'content' => 'Zespół Lekam Akademia',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'verification',
            ],

            // Email resetowania hasła
            [
                'key' => 'emails.reset_password.subject',
                'title' => 'Temat emaila resetowania hasła',
                'content' => 'Resetowanie hasła - Lekam Akademia',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'reset_password',
            ],
            [
                'key' => 'emails.reset_password.greeting',
                'title' => 'Powitanie w emailu resetowania hasła',
                'content' => 'Cześć!',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'reset_password',
            ],
            [
                'key' => 'emails.reset_password.intro',
                'title' => 'Treść wprowadzająca email resetowania hasła',
                'content' => 'Otrzymujesz ten email, ponieważ otrzymaliśmy prośbę o zresetowanie hasła dla Twojego konta w Akademii Lekam.',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'reset_password',
            ],
            [
                'key' => 'emails.reset_password.button_text',
                'title' => 'Tekst przycisku resetowania',
                'content' => 'Resetuj hasło',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'reset_password',
            ],
            [
                'key' => 'emails.reset_password.expiry_info',
                'title' => 'Informacja o wygaśnięciu linku',
                'content' => 'Ten link wygaśnie za :count minut.',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'reset_password',
            ],
            [
                'key' => 'emails.reset_password.footer',
                'title' => 'Stopka emaila resetowania hasła',
                'content' => 'Jeśli nie prosiłeś o zresetowanie hasła, zignoruj tę wiadomość.',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'reset_password',
            ],
            [
                'key' => 'emails.reset_password.signature',
                'title' => 'Podpis emaila resetowania hasła',
                'content' => 'Zespół Lekam Akademia',
                'type' => 'text',
                'page' => 'emails',
                'section' => 'reset_password',
            ],
        ];

        foreach ($emailContents as $content) {
            Content::updateOrCreate(
                ['key' => $content['key']],
                array_merge($content, ['is_active' => true])
            );
        }
    }
}