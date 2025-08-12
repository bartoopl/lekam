<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            [
                'name' => 'Dr. Anna Kowalska',
                'email' => 'anna.kowalska@farmaceutyczna.pl',
                'specialization' => 'Farmakologia kliniczna',
                'bio' => 'Doktor nauk farmaceutycznych z 15-letnim doświadczeniem w farmakologii klinicznej. Specjalizuje się w interakcjach lekowych i farmakoterapii.',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Piotr Nowak',
                'email' => 'piotr.nowak@farmaceutyczna.pl',
                'specialization' => 'Technologia leków',
                'bio' => 'Ekspert w dziedzinie technologii leków z wieloletnim doświadczeniem w przemyśle farmaceutycznym. Specjalizuje się w formulacjach leków.',
                'is_active' => true,
            ],
            [
                'name' => 'Mgr. Maria Wiśniewska',
                'email' => 'maria.wisniewska@farmaceutyczna.pl',
                'specialization' => 'Farmacja apteczna',
                'bio' => 'Magister farmacji z 10-letnim doświadczeniem w farmacji aptecznej. Specjalizuje się w opiece farmaceutycznej i doradztwie pacjentom.',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Tomasz Zieliński',
                'email' => 'tomasz.zielinski@farmaceutyczna.pl',
                'specialization' => 'Toksykologia',
                'bio' => 'Doktor nauk farmaceutycznych specjalizujący się w toksykologii. Ekspert w dziedzinie bezpieczeństwa leków i monitorowania działań niepożądanych.',
                'is_active' => true,
            ],
            [
                'name' => 'Mgr. Katarzyna Dąbrowska',
                'email' => 'katarzyna.dabrowska@farmaceutyczna.pl',
                'specialization' => 'Farmacja szpitalna',
                'bio' => 'Magister farmacji z doświadczeniem w farmacji szpitalnej. Specjalizuje się w lekach cytostatycznych i terapii onkologicznej.',
                'is_active' => true,
            ],
        ];

        foreach ($instructors as $instructor) {
            Instructor::create($instructor);
        }
    }
}
