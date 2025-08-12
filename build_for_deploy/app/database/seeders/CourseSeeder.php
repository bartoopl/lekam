<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pobierz instruktorów lub stwórz domyślnego
        $instructor = Instructor::first() ?? Instructor::create([
            'name' => 'Dr Anna Kowalska',
            'email' => 'anna.kowalska@lekam.pl',
            'bio' => 'Specjalista w dziedzinie farmakologii klinicznej z 15-letnim doświadczeniem.',
        ]);

        $courses = [
            [
                'title' => 'Podstawy Farmakologii',
                'description' => 'Wprowadzenie do podstawowych zagadnień farmakologii, mechanizmów działania leków i ich zastosowania w praktyce aptecznej.',
                'difficulty' => 'podstawowy',
                'duration_minutes' => 480, // 8 godzin
                'is_active' => true,
            ],
            [
                'title' => 'Interakcje Leków',
                'description' => 'Szczegółowy kurs o interakcjach między lekami, ich mechanizmach i znaczeniu klinicznym.',
                'difficulty' => 'średni',
                'duration_minutes' => 720, // 12 godzin
                'is_active' => true,
            ],
            [
                'title' => 'Prawo Farmaceutyczne',
                'description' => 'Aktualne przepisy prawne dotyczące prowadzenia apteki, wydawania leków i obowiązków farmaceuty.',
                'difficulty' => 'średni',
                'duration_minutes' => 600, // 10 godzin
                'is_active' => true,
            ],
            [
                'title' => 'Farmakoterapia w Pediatrii',
                'description' => 'Specjalistyczny kurs o stosowaniu leków u dzieci, dawkowaniu i specyfice pediatrycznej.',
                'difficulty' => 'zaawansowany',
                'duration_minutes' => 960, // 16 godzin
                'is_active' => true,
            ],
            [
                'title' => 'Suplementy Diety i Żywność Funkcjonalna',
                'description' => 'Kompleksowy przegląd suplementów diety, ich składników aktywnych i zasad stosowania.',
                'difficulty' => 'podstawowy',
                'duration_minutes' => 360, // 6 godzin
                'is_active' => true,
            ],
            [
                'title' => 'Onkologia Apteczna',
                'description' => 'Zaawansowany kurs o lekach przeciwnowotworowych, ich przechowywaniu i wydawaniu.',
                'difficulty' => 'zaawansowany',
                'duration_minutes' => 1200, // 20 godzin
                'is_active' => true,
            ],
        ];

        foreach ($courses as $courseData) {
            Course::create($courseData);
        }
    }
}