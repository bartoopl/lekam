<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Chapter;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, clear existing lessons to avoid duplicates
        Lesson::truncate();
        
        $chapters = Chapter::all();

        foreach ($chapters as $chapter) {
            // Create 3 lessons per chapter
            $lessons = [
                [
                    'title' => 'Lekcja 1: ' . $chapter->title,
                    'content' => '<h2>Wprowadzenie</h2><p>Witamy w pierwszej lekcji rozdziału: ' . $chapter->title . '</p><p>W tej lekcji omówimy podstawowe zagadnienia związane z tym tematem.</p><h3>Cele lekcji:</h3><ul><li>Zrozumienie podstawowych pojęć</li><li>Praktyczne zastosowanie wiedzy</li><li>Przygotowanie do dalszej nauki</li></ul>',
                    'order' => 1,
                    'is_required' => true,
                ],
                [
                    'title' => 'Lekcja 2: Szczegóły',
                    'content' => '<h2>Szczegółowe omówienie</h2><p>W tej lekcji zagłębimy się w szczegóły poruszanego tematu.</p><p>Omówimy praktyczne przykłady i case studies.</p><h3>Kluczowe punkty:</h3><ul><li>Analiza konkretnych przypadków</li><li>Najlepsze praktyki w branży</li><li>Typowe błędy i jak ich unikać</li></ul>',
                    'order' => 2,
                    'is_required' => true,
                ],
                [
                    'title' => 'Lekcja 3: Praktyczne zastosowanie i test',
                    'content' => '<h2>Zastosowanie w praktyce</h2><p>Czas na praktyczne zastosowanie zdobytej wiedzy.</p><p>Wykonamy ćwiczenia i zadania praktyczne.</p><h3>Ćwiczenia:</h3><ul><li>Zadanie praktyczne nr 1</li><li>Analiza przypadku</li><li>Quiz sprawdzający</li></ul><p><strong>Przygotuj się do testu końcowego!</strong></p>',
                    'order' => 3,
                    'is_required' => true,
                    'is_last_lesson' => true,
                ],
            ];

            // Mark first lesson
            $lessons[0]['is_first_lesson'] = true;

            foreach ($lessons as $lessonData) {
                Lesson::create([
                    'course_id' => $chapter->course_id,
                    'chapter_id' => $chapter->id, // KLUCZOWA ZMIANA - dodajemy chapter_id
                    'title' => $lessonData['title'],
                    'content' => $lessonData['content'],
                    'order' => $lessonData['order'],
                    'is_required' => $lessonData['is_required'],
                    'is_first_lesson' => $lessonData['is_first_lesson'] ?? false,
                    'is_last_lesson' => $lessonData['is_last_lesson'] ?? false,
                ]);
            }
        }
    }
}