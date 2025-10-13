<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'time_limit_minutes',
        'passing_score',
        'questions_to_draw',
        'min_correct_answers',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the course that owns the quiz
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the questions for this quiz
     */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    /**
     * Get the attempts for this quiz
     */
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get the maximum possible score for this quiz
     * If questions_to_draw is set, returns max score for that many questions
     * Otherwise returns sum of all questions
     */
    public function getMaxScore(): int
    {
        if ($this->questions_to_draw) {
            // Return score for the number of questions that will be drawn
            // Assuming each question is worth 1 point
            return $this->questions_to_draw;
        }

        return $this->questions()->sum('points');
    }

    /**
     * Check if user has passed this quiz
     */
    public function hasUserPassed(User $user): bool
    {
        $bestAttempt = $this->attempts()
            ->where('user_id', $user->id)
            ->where('passed', true)
            ->orderBy('percentage', 'desc')
            ->first();

        return $bestAttempt !== null;
    }

    /**
     * Get user's best attempt
     */
    public function getUserBestAttempt(User $user)
    {
        return $this->attempts()
            ->where('user_id', $user->id)
            ->orderBy('percentage', 'desc')
            ->first();
    }

    /**
     * Get random questions for a quiz attempt
     */
    public function getRandomQuestions(): \Illuminate\Database\Eloquent\Collection
    {
        $totalQuestions = $this->questions()->count();
        $questionsToTake = $this->questions_to_draw ?? $totalQuestions;

        // If questions_to_draw is null or greater than available questions, use all
        if ($questionsToTake >= $totalQuestions) {
            return $this->questions;
        }

        // Randomly select questions
        return $this->questions()->inRandomOrder()->limit($questionsToTake)->get();
    }

    /**
     * Get max score for specific questions
     */
    public function getMaxScoreForQuestions(array $questionIds): int
    {
        return $this->questions()->whereIn('id', $questionIds)->sum('points');
    }
}
