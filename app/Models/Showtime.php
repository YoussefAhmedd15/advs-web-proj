<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Showtime extends Model
{
    protected $fillable = [
        'movie_id',
        'screen_id',
        'time',
        'date',
        'price',
        'is_active'
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
} 