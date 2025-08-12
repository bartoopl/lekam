<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'bio',
        'specialization',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the lessons for this instructor
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Get the courses this instructor teaches
     */
    public function courses()
    {
        return $this->hasManyThrough(Course::class, Lesson::class);
    }

    /**
     * Get active instructors
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get instructor's full name
     */
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    /**
     * Get instructor's photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        
        // Return default avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7C3AED&background=EBF4FF';
    }
}
