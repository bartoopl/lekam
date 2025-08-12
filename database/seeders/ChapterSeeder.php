<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chapter;
use App\Models\Course;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            // Create chapters for each course
            $chapters = [
                [
                    'title' => 'Wprowadzenie do farmacji',
                    'description' => 'Podstawowe zagadnienia i wprowadzenie do tematu',
                    'order' => 1,
                ],
                [
                    'title' => 'Podstawy farmakologii',
                    'description' => 'Teoretyczne podstawy działania leków',
                    'order' => 2,
                ],
                [
                    'title' => 'Praktyczne zastosowania',
                    'description' => 'Praktyczne aspekty pracy w aptece',
                    'order' => 3,
                ],
            ];

            foreach ($chapters as $chapterData) {
                Chapter::create([
                    'course_id' => $course->id,
                    'title' => $chapterData['title'],
                    'description' => $chapterData['description'],
                    'order' => $chapterData['order'],
                ]);
            }
        }
    }
}
