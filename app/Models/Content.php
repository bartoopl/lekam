<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'key',
        'title',
        'content',
        'type',
        'page',
        'section',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getByKey($key)
    {
        return static::where('key', $key)->where('is_active', true)->first()?->content;
    }

    public static function getPageContents($page)
    {
        return static::where('page', $page)->where('is_active', true)->get()->keyBy('key');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePage($query, $page)
    {
        return $query->where('page', $page);
    }

    public static function getGroupedByPage()
    {
        return static::where('is_active', true)
            ->orderBy('page')
            ->orderBy('section')
            ->get()
            ->groupBy('page');
    }

    public static function getPageInfo()
    {
        return [
            'home' => [
                'title' => 'Strona główna',
                'description' => 'Treści wyświetlane na stronie głównej',
                'icon' => '🏠'
            ],
            'courses' => [
                'title' => 'Szkolenia',
                'description' => 'Treści strony szkoleń',
                'icon' => '📚'
            ],
            'contact' => [
                'title' => 'Kontakt',
                'description' => 'Dane kontaktowe i informacje',
                'icon' => '📞'
            ],
            'emails' => [
                'title' => 'Szablony emaili',
                'description' => 'Treści wysyłanych wiadomości email',
                'icon' => '📧'
            ]
        ];
    }
}
