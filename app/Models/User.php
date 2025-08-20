<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'license_number',
        'bio',
        'phone',
        'pwz_number',
        'pharmacy_address',
        'pharmacy_postal_code',
        'pharmacy_city',
        'ref',
        'representative_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's progress for all courses
     */
    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Get the user's quiz attempts
     */
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get the user's certificates
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get the representative that referred this user
     */
    public function representative()
    {
        return $this->belongsTo(Representative::class);
    }

    /**
     * Check if user is a pharmacist
     */
    public function isPharmacist(): bool
    {
        return $this->user_type === 'farmaceuta';
    }

    /**
     * Check if user is a pharmacy technician
     */
    public function isTechnician(): bool
    {
        return $this->user_type === 'technik_farmacji';
    }

    /**
     * Check if user is an administrator
     */
    public function isAdmin(): bool
    {
        // For now, we'll consider users with email containing 'admin' as administrators
        // In production, you should add an 'is_admin' column to the users table
        return str_contains(strtolower($this->email), 'admin') || $this->email === 'bartosz@creativetrust.pl' || $this->email === 'bartosz.lysniewski@gmail.com';
    }

    /**
     * Check if user has started a course
     */
    public function hasStartedCourse(Course $course): bool
    {
        return $this->progress()
            ->where('course_id', $course->id)
            ->where('is_completed', false)
            ->exists();
    }

    /**
     * Check if user has completed a course
     */
    public function hasCompletedCourse(Course $course): bool
    {
        return $this->progress()
            ->where('course_id', $course->id)
            ->where('is_completed', true)
            ->exists();
    }

    /**
     * Get the user's score multiplier based on user type
     */
    public function getScoreMultiplier(): float
    {
        return $this->user_type === 'farmaceuta' ? 1.0 : 0.8;
    }
}
