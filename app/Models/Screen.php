<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_blocked',
        'blocked_message',
        'content_order',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
    ];

    public function manualSlides()
    {
        return $this->belongsToMany(ManualSlide::class)
            ->withTimestamps();
    }
}