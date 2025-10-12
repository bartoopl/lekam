<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_type',
        'course_id',
        'pdf_path',
        'fields_config',
        'next_certificate_number',
        'certificate_prefix',
        'is_active',
    ];

    protected $casts = [
        'fields_config' => 'array',
        'next_certificate_number' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the course for this template
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get certificates using this template
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Find appropriate template for user and course
     */
    public static function findTemplateFor(User $user, Course $course): ?self
    {
        // 1. Sprawdź czy kurs ma dedykowany szablon dla typu użytkownika
        $template = self::where('course_id', $course->id)
            ->where('user_type', $user->user_type)
            ->where('is_active', true)
            ->first();

        if ($template) {
            return $template;
        }

        // 2. Sprawdź czy kurs ma uniwersalny szablon (dla wszystkich typów)
        $template = self::where('course_id', $course->id)
            ->whereNull('user_type')
            ->where('is_active', true)
            ->first();

        if ($template) {
            return $template;
        }

        // 3. Użyj domyślnego szablonu dla typu użytkownika
        $template = self::whereNull('course_id')
            ->where('user_type', $user->user_type)
            ->where('is_active', true)
            ->first();

        return $template;
    }

    /**
     * Generate next certificate number for this template
     */
    public function generateNextCertificateNumber(): string
    {
        $year = date('Y');
        $number = str_pad($this->next_certificate_number, 3, '0', STR_PAD_LEFT);

        // Increment counter
        $this->increment('next_certificate_number');

        return "{$this->certificate_prefix}/{$number}/{$year}";
    }

    /**
     * Get default field positions (if fields_config is empty)
     */
    public function getDefaultFieldsConfig(): array
    {
        return [
            'certificate_number' => ['x' => 400, 'y' => 50, 'font_size' => 10],
            'user_name' => ['x' => 200, 'y' => 300, 'font_size' => 20, 'align' => 'center'],
            'course_title' => ['x' => 200, 'y' => 350, 'font_size' => 14, 'align' => 'center'],
            'completion_date' => ['x' => 150, 'y' => 450, 'font_size' => 12],
            'points' => ['x' => 450, 'y' => 450, 'font_size' => 12],
        ];
    }

    /**
     * Get fields config with defaults
     */
    public function getFieldsConfig(): array
    {
        return $this->fields_config ?? $this->getDefaultFieldsConfig();
    }
}
