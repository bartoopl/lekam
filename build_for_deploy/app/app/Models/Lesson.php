<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'chapter_id',
        'title',
        'content',
        'order',
        'instructor_id',
        'downloadable_materials',
        'download_timer_minutes',
        'requires_download_completion',
        'video_file',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'requires_file_download' => 'boolean',
        'is_first_lesson' => 'boolean',
        'is_last_lesson' => 'boolean',
        'requires_download_completion' => 'boolean',
        'downloadable_materials' => 'array',
    ];

    /**
     * Get the course that owns the lesson
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the chapter that owns the lesson
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Get the instructor for this lesson
     */
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    /**
     * Get user progress for this lesson
     */
    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Get the next lesson in the course
     */
    public function nextLesson()
    {
        return $this->course->lessons()
            ->where('order', '>', $this->order)
            ->orderBy('order')
            ->first();
    }

    /**
     * Get the previous lesson in the course
     */
    public function previousLesson()
    {
        return $this->course->lessons()
            ->where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    /**
     * Check if lesson is accessible by user
     */
    public function isAccessibleByUser(User $user): bool
    {
        // First lesson is always accessible
        if ($this->is_first_lesson) {
            return true;
        }

        // Check if previous lesson is completed
        $previousLesson = $this->previousLesson();
        if (!$previousLesson) {
            return true;
        }

        // If previous lesson is not completed, this lesson is not accessible
        if (!$previousLesson->isCompletedByUser($user)) {
            return false;
        }

        // If previous lesson requires download completion and has a timer, check if timer has expired
        if ($previousLesson->requires_download_completion && $previousLesson->download_timer_minutes > 0) {
            $progress = $previousLesson->userProgress()->where('user_id', $user->id)->first();
            
            if ($progress && $progress->file_downloaded_at && $progress->can_proceed_after) {
                // Check if the timer has expired
                return now()->isAfter($progress->can_proceed_after);
            }
        }

        return true;
    }

    /**
     * Check if lesson is completed by user
     */
    public function isCompletedByUser(User $user): bool
    {
        return $this->userProgress()
            ->where('user_id', $user->id)
            ->where('is_completed', true)
            ->exists();
    }

    /**
     * Mark lesson as completed for user
     */
    public function markAsCompleted(User $user): void
    {
        $this->userProgress()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'course_id' => $this->course_id,
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );
    }

    /**
     * Mark file as downloaded for user
     */
    public function markFileAsDownloaded(User $user): void
    {
        $progress = $this->userProgress()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'course_id' => $this->course_id,
                'file_downloaded_at' => now(),
                'can_proceed_after' => now()->addMinutes($this->download_timer_minutes),
            ]
        );

        // If no timer is set, complete the lesson immediately
        if (!$this->download_timer_minutes || $this->download_timer_minutes <= 0) {
            $this->markAsCompleted($user);
        }
    }

    /**
     * Check if user can proceed after download
     */
    public function canUserProceedAfterDownload(User $user): bool
    {
        $progress = $this->userProgress()
            ->where('user_id', $user->id)
            ->first();

        if (!$progress || !$progress->file_downloaded_at) {
            return false;
        }

        return now()->isAfter($progress->can_proceed_after);
    }

    /**
     * Get downloadable materials as array
     */
    public function getDownloadableMaterialsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set downloadable materials as JSON
     */
    public function setDownloadableMaterialsAttribute($value)
    {
        $this->attributes['downloadable_materials'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Check if lesson has downloadable materials
     */
    public function hasDownloadableMaterials(): bool
    {
        return !empty($this->downloadable_materials);
    }

    /**
     * Get remaining time for download timer
     */
    public function getRemainingDownloadTime(User $user): ?int
    {
        $progress = $this->userProgress()
            ->where('user_id', $user->id)
            ->first();

        if (!$progress || !$progress->file_downloaded_at || !$progress->can_proceed_after) {
            return null;
        }

        $remaining = $progress->can_proceed_after->diffInSeconds(now());
        return $remaining > 0 ? $remaining : 0;
    }

    /**
     * Check if download timer has expired and auto-complete lesson
     */
    public function checkAndCompleteIfTimerExpired(User $user): bool
    {
        $progress = $this->userProgress()->where('user_id', $user->id)->first();
        
        if (!$progress || !$progress->file_downloaded_at || $progress->is_completed) {
            return false;
        }

        // Check if timer has expired
        if ($progress->can_proceed_after && now()->isAfter($progress->can_proceed_after)) {
            $this->markAsCompleted($user);
            return true;
        }

        return false;
    }
}
