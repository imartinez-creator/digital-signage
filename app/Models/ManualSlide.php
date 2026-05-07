<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualSlide extends Model
{
    protected $fillable = [
        'title',
        'body',
        'image_url',
        'is_active',
        'is_pinned',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    public function screens()
    {
        return $this->belongsToMany(Screen::class)
            ->withTimestamps();
    }
}