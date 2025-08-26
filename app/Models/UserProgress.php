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

    // Debug logging for lesson 19
    protected static function booted()
    {
        // Test if booted is called
        \Log::info("🔍 DEBUG UserProgress booted() called");
        
        static::creating(function (UserProgress $progress) {
            \Log::info("🔍 DEBUG UserProgress CREATING any lesson", [
                'lesson_id' => $progress->lesson_id,
                'user_id' => $progress->user_id,
                'is_completed' => $progress->is_completed
            ]);
            
            if ($progress->lesson_id == 19) {
                \Log::info("🔍 DEBUG UserProgress CREATING for lesson 19", [
                    'user_id' => $progress->user_id,
                    'is_completed' => $progress->is_completed,
                    'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 8)
                ]);
            }
        });

        static::updating(function (UserProgress $progress) {
            \Log::info("🔍 DEBUG UserProgress UPDATING any lesson", [
                'lesson_id' => $progress->lesson_id,
                'user_id' => $progress->user_id,
                'is_completed' => $progress->is_completed
            ]);
            
            if ($progress->lesson_id == 19) {
                \Log::info("🔍 DEBUG UserProgress UPDATING for lesson 19", [
                    'user_id' => $progress->user_id,
                    'is_completed' => $progress->is_completed,
                    'original_is_completed' => $progress->getOriginal('is_completed'),
                    'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 8)
                ]);
            }
        });
    }

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
