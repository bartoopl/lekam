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
     *
     * Available fields:
     * - certificate_number: Position for "ZAŚWIADCZENIE nr [number]"
     * - user_name: Position for user's full name
     * - completion_date: Position for "odbył/odbyła w dniu [date] kurs szkoleniowy:"
     * - course_subtitle: [OPTIONAL] Position for additional text before course title (for technik_farmacji)
     * - course_title: Position for course title (supports multiline)
     * - points: Position for "liczba punktów edukacyjnych: [X] pkt"
     * - duration_hours: [OPTIONAL] Position for "liczba godzin szkoleniowych: [X] godz." (for technik_farmacji)
     * - city: Position for city and date, e.g., "Warszawa, dnia [date]" (with 'value' key for city name)
     * - expiry_date: [DEPRECATED] Use 'city' instead. Fallback for "Gdańsk, dnia [date]"
     */
    public function getDefaultFieldsConfig(): array
    {
        return [
            'certificate_number' => ['y' => 50, 'font_size' => 10],
            'user_name' => ['y' => 300, 'font_size' => 20],
            'completion_date' => ['y' => 450, 'font_size' => 12],
            'course_title' => ['y' => 350, 'font_size' => 14],
            'points' => ['y' => 450, 'font_size' => 12],
            // Optional fields (commented out - add to template config if needed):
            // 'course_subtitle' => ['y' => 380, 'font_size' => 11],
            // 'duration_hours' => ['y' => 480, 'font_size' => 12],
            // 'city' => ['y' => 700, 'font_size' => 12, 'value' => 'Warszawa'],
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
