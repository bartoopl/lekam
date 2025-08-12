<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'quiz_attempt_id',
        'certificate_number',
        'pdf_path',
        'issued_at',
        'expires_at',
        'is_valid',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_valid' => 'boolean',
    ];

    /**
     * Get the user that owns the certificate
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course for this certificate
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the quiz attempt for this certificate
     */
    public function quizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class);
    }

    /**
     * Generate certificate number
     */
    public static function generateCertificateNumber(): string
    {
        $prefix = 'CERT';
        $year = date('Y');
        $random = strtoupper(substr(md5(uniqid()), 0, 8));
        
        return "{$prefix}-{$year}-{$random}";
    }

    /**
     * Check if certificate is expired
     */
    public function isExpired(): bool
    {
        if (!$this->expires_at) {
            return false;
        }

        return now()->gt($this->expires_at);
    }

    /**
     * Get certificate status
     */
    public function getStatus(): string
    {
        if (!$this->is_valid) {
            return 'invalid';
        }

        if ($this->isExpired()) {
            return 'expired';
        }

        return 'valid';
    }
}
