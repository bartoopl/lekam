<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'options',
        'correct_answers',
        'points',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answers' => 'array',
    ];

    /**
     * Get the quiz that owns the question
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Check if answer is correct
     */
    public function isAnswerCorrect($userAnswer): bool
    {
        if ($this->type === 'single_choice') {
            return in_array($userAnswer, $this->correct_answers);
        }

        if ($this->type === 'multiple_choice') {
            if (!is_array($userAnswer)) {
                return false;
            }
            
            sort($userAnswer);
            sort($this->correct_answers);
            
            return $userAnswer === $this->correct_answers;
        }

        if ($this->type === 'true_false') {
            return $userAnswer === $this->correct_answers[0];
        }

        return false;
    }

    /**
     * Get points for answer
     */
    public function getPointsForAnswer($userAnswer): int
    {
        return $this->isAnswerCorrect($userAnswer) ? $this->points : 0;
    }
}
