<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Representative extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'code',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Users registered through this representative
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Generate unique code for representative
     */
    public static function generateCode(): string
    {
        do {
            $code = Str::random(8);
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    /**
     * Get registration URL for this representative
     */
    public function getRegistrationUrlAttribute(): string
    {
        return route('register') . '?rep=' . $this->code;
    }

    /**
     * Get QR code URL for this representative
     */
    public function getQrCodeUrlAttribute(): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($this->registration_url);
    }

    /**
     * Count users registered through this representative
     */
    public function getUsersCountAttribute(): int
    {
        return $this->users()->count();
    }
}
