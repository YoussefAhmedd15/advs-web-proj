<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'showtime_id',
        'number_of_tickets',
        'status',
        'confirmation_code',
        'amount',
        'payment_status',
        'payment_method',
        'transaction_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (empty($booking->confirmation_code)) {
                $booking->confirmation_code = strtoupper(Str::random(8));
            }
            if (empty($booking->status)) {
                $booking->status = 'pending';
            }
            if (empty($booking->payment_status)) {
                $booking->payment_status = 'unpaid';
            }
        });

        static::updating(function ($booking) {
            if ($booking->isDirty('payment_status') && $booking->payment_status === 'paid') {
                $booking->paid_at = now();
            }
            if ($booking->isDirty('status') && $booking->status === 'cancelled') {
                $booking->cancelled_at = now();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function showtime(): BelongsTo
    {
        return $this->belongsTo(Showtime::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }

    public function calculateTotalAmount()
    {
        return $this->number_of_tickets * $this->price_per_ticket;
    }

    public function isAvailable()
    {
        // Get total booked tickets for this showtime
        $totalBooked = self::where('showtime_id', $this->showtime_id)
            ->where('status', '!=', 'cancelled')
            ->sum('number_of_tickets');

        // Get screen capacity
        $screenCapacity = $this->showtime->screen->capacity;

        // Check if there's enough space for this booking
        return ($totalBooked + $this->number_of_tickets) <= $screenCapacity;
    }
} 