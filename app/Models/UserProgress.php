<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'is_completed',
        'video_position',
        'completed_at',
        'file_downloaded_at',
        'can_proceed_after',
        'time_spent_seconds',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'file_downloaded_at' => 'datetime',
        'can_proceed_after' => 'datetime',
    ];

    /**
     * Get the user that owns the progress
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course for this progress
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lesson for this progress
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
