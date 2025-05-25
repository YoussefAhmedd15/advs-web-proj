<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'showtime_id',
        'seat_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'amount'
    ];

    protected $casts = [
        'status' => 'string',
        'amount' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function showtime(): BelongsTo
    {
        return $this->belongsTo(Showtime::class);
    }

    public function seats(): BelongsToMany
    {
        return $this->belongsToMany(Seat::class, 'booking_seats')
            ->withPivot('price')
            ->withTimestamps();
    }
} 