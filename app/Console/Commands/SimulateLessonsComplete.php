<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Course;
use App\Models\UserProgress;

class SimulateLessonsComplete extends Command
{
    protected $signature = 'simulate:lessons-complete {email} {--course_id=}';
    protected $description = 'Mark all lessons as completed for a user, without creating a quiz attempt';

    public function handle()
    {
        $email = $this->argument('email');
        $courseId = $this->option('course_id');

        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("User not found: $email");
            return 1;
        }

        $coursesQuery = Course::query();
        if ($courseId) {
            $coursesQuery->where('id', $courseId);
        }
        $courses = $coursesQuery->with('lessons')->get();

        if ($courses->isEmpty()) {
            $this->warn('No courses found to simulate.');
            return 0;
        }

        $totalUpdated = 0;
        foreach ($courses as $course) {
            foreach ($course->lessons as $lesson) {
                $progress = UserProgress::firstOrNew([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'lesson_id' => $lesson->id,
                ]);
                $progress->is_completed = true;
                $progress->completed_at = now();
                // If lesson has materials timer, set can_proceed_after to now() to allow quiz access logic to handle timers
                if ($lesson->requires_download_completion || ($lesson->download_timer_minutes ?? 0) > 0) {
                    $progress->can_proceed_after = now();
                }
                $progress->save();
                $totalUpdated++;
            }
        }

        $this->info("Updated progress entries: $totalUpdated for user $email");
        $this->info('Note: No quiz attempts were created.');
        return 0;
    }
}


