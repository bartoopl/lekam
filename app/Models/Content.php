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
}
