<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'genre',
        'duration',
        'synopsis',
        'description',
        'poster',
        'trailer_url',
        'rating',
        'is_active'
    ];

    protected $casts = [
        'duration' => 'integer',
        'rating' => 'float',
        'is_active' => 'boolean'
    ];

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
} 