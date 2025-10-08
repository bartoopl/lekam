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
        'correct_answers_count',
        'max_score',
        'percentage',
        'passed',
        'started_at',
        'completed_at',
        'answers',
        'earned_points',
        'selected_question_ids',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'answers' => 'array',
        'selected_question_ids' => 'array',
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
     * Get the selected questions for this attempt
     */
    public function getSelectedQuestions()
    {
        if (empty($this->selected_question_ids)) {
            return $this->quiz->questions;
        }

        return QuizQuestion::whereIn('id', $this->selected_question_ids)
            ->orderBy('order')
            ->get();
    }

    /**
     * Calculate score from answers
     */
    public function calculateScore(): void
    {
        $score = 0;
        $correctAnswers = 0;
        $answers = $this->answers ?? [];

        // Use selected questions if available, otherwise use all questions
        $questions = $this->getSelectedQuestions();

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $points = $question->getPointsForAnswer($userAnswer);
            $score += $points;

            // Count correct answers
            if ($points > 0) {
                $correctAnswers++;
            }
        }

        $this->score = $score;

        // Calculate max score based on selected questions
        if (!empty($this->selected_question_ids)) {
            $this->max_score = $this->quiz->getMaxScoreForQuestions($this->selected_question_ids);
        } else {
            $this->max_score = $this->quiz->getMaxScore();
        }

        // Store correct answers count for potential use
        $this->correct_answers_count = $correctAnswers;
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
        // If min_correct_answers is set, use that instead of percentage
        if ($this->quiz->min_correct_answers !== null) {
            return ($this->correct_answers_count ?? 0) >= $this->quiz->min_correct_answers;
        }

        // Otherwise use percentage-based passing score
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
