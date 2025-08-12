<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'max_score',
        'percentage',
        'passed',
        'started_at',
        'completed_at',
        'answers',
        'earned_points',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'answers' => 'array',
    ];

    /**
     * Get the user that owns the attempt
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz for this attempt
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Calculate score from answers
     */
    public function calculateScore(): void
    {
        $score = 0;
        $answers = $this->answers ?? [];
        
        foreach ($this->quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $score += $question->getPointsForAnswer($userAnswer);
        }
        
        $this->score = $score;
        $this->max_score = $this->quiz->getMaxScore();
    }

    /**
     * Calculate percentage
     */
    public function calculatePercentage(): float
    {
        if ($this->max_score === 0) {
            return 0;
        }

        return round(($this->score / $this->max_score) * 100, 2);
    }

    /**
     * Check if attempt passed
     */
    public function checkIfPassed(): bool
    {
        return $this->percentage >= $this->quiz->passing_score;
    }

    /**
     * Apply points based on user type when course is completed
     */
    public function applyScoreMultiplier(): void
    {
        $user = $this->user;
        $course = $this->quiz->course;
        
        // Get points for user type from course
        $coursePoints = $course->getPointsForUser($user);
        
        if ($coursePoints > 0 && $this->passed) {
            // User gets full points for their type when they pass the test
            $this->earned_points = $coursePoints;
            $this->save();
        }
    }
}
