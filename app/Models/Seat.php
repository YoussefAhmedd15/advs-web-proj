<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Seat extends Model
{
    protected $fillable = [
        'screen_id',
        'seat_number',
        'row_number',
        'column_number',
        'type',
        'price_multiplier',
        'is_active'
    ];

    protected $casts = [
        'price_multiplier' => 'decimal:2'
    ];

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_seats')
            ->withPivot('price')
            ->withTimestamps();
    }
} 