<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'duration_minutes',
        'is_active',
        'requires_sequential_lessons',
        'pharmacist_points',
        'technician_points',
        'certificate_header',
        'certificate_footer',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_sequential_lessons' => 'boolean',
        'pharmacist_points' => 'integer',
        'technician_points' => 'integer',
    ];

    /**
     * Get the lessons for this course
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('order');
    }

    /**
     * Get the quiz for this course
     */
    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

    /**
     * Get user progress for this course
     */
    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Get certificates for this course
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get the first lesson
     */
    public function firstLesson()
    {
        return $this->hasOne(Lesson::class)->where('is_first_lesson', true);
    }

    /**
     * Get the last lesson
     */
    public function lastLesson()
    {
        return $this->hasOne(Lesson::class)->where('is_last_lesson', true);
    }

    /**
     * Check if course is completed by user
     */
    public function isCompletedByUser(User $user): bool
    {
        // If course has first/last lesson structure, check if last lesson is completed
        $lastLesson = $this->lessons()->where('is_last_lesson', true)->first();
        if ($lastLesson) {
            return $lastLesson->isCompletedByUser($user);
        }

        // Fallback to traditional logic for courses without first/last structure
        $lessons = $this->lessons;
        $totalLessons = $lessons->count();
        
        if ($totalLessons === 0) {
            return false;
        }
        
        $completedLessons = 0;
        
        foreach ($lessons as $lesson) {
            if ($lesson->isCompletedByUser($user)) {
                // If lesson requires download completion with timer, check if timer has expired
                if ($lesson->requires_download_completion && $lesson->download_timer_minutes > 0) {
                    if ($lesson->canUserProceedAfterDownload($user)) {
                        $completedLessons++;
                    }
                } else {
                    $completedLessons++;
                }
            }
        }

        return $totalLessons === $completedLessons;
    }

    /**
     * Check if user can access materials (after completing last lesson)
     */
    public function canUserAccessMaterials(User $user): bool
    {
        // Materials are accessible only after the last lesson (video) is completed
        $lastLesson = $this->lessons()->where('is_last_lesson', true)->first();
        
        if (!$lastLesson) {
            // Fallback: if no last lesson marked, check if all video lessons are completed
            $videoLessons = $this->lessons()->where('requires_download_completion', false)->get();
            foreach ($videoLessons as $lesson) {
                if (!$lesson->isCompletedByUser($user)) {
                    return false;
                }
            }
            return true;
        }
        
        // Check if the last lesson is completed
        return $lastLesson->isCompletedByUser($user);
    }

    /**
     * Check if user can access quiz (after materials timer completion)
     */
    public function canUserAccessQuiz(User $user): bool
    {
        if (!$this->isCompletedByUser($user)) {
            return false;
        }

        // Find lessons with materials and check if timer has expired
        $lessonsWithMaterials = $this->lessons()
            ->where(function($query) {
                $query->where('requires_download_completion', true)
                      ->orWhere('download_timer_minutes', '>', 0);
            })
            ->get();

        foreach ($lessonsWithMaterials as $lesson) {
            if (!$lesson->canUserProceedAfterDownload($user)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if user can access quiz and materials (after last lesson completion) - deprecated
     */
    public function canUserAccessQuizAndMaterials(User $user): bool
    {
        return $this->canUserAccessMaterials($user);
    }

    /**
     * Get completion percentage for user
     */
    public function getCompletionPercentage(User $user): float
    {
        $totalLessons = $this->lessons()->count();
        if ($totalLessons === 0) return 0;

        $completedLessons = $this->userProgress()
            ->where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        return round(($completedLessons / $totalLessons) * 100, 2);
    }

    /**
     * Get points for specific user type
     */
    public function getPointsForUserType(string $userType): int
    {
        return match($userType) {
            'farmaceuta' => $this->pharmacist_points ?? 0,
            'technik_farmacji' => $this->technician_points ?? 0,
            'admin' => $this->pharmacist_points ?? 0, // Admin gets pharmacist points
            default => 0,
        };
    }

    /**
     * Get points for user
     */
    public function getPointsForUser(User $user): int
    {
        return $this->getPointsForUserType($user->user_type);
    }
}
