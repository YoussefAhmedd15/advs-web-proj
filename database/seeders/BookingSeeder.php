<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $showtimes = Showtime::all();
        $statuses = ['pending', 'confirmed', 'cancelled'];
        $paymentMethods = ['credit_card', 'debit_card', 'cash'];
        
        // Create 50 sample bookings
        for ($i = 0; $i < 50; $i++) {
            $showtime = $showtimes->random();
            $numSeats = rand(1, 4);
            $totalAmount = $showtime->base_price * $numSeats;
            
            $booking = Booking::create([
                'showtime_id' => $showtime->id,
                'customer_name' => 'Customer ' . ($i + 1),
                'customer_email' => 'customer' . ($i + 1) . '@example.com',
                'customer_phone' => '+1' . rand(2000000000, 9999999999),
                'num_seats' => $numSeats,
                'total_amount' => $totalAmount,
                'status' => $statuses[array_rand($statuses)],
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_status' => rand(0, 1) ? 'paid' : 'pending',
                'booking_date' => Carbon::now()->subDays(rand(0, 30)),
                'special_requests' => rand(0, 1) ? 'Wheelchair accessible' : null,
            ]);

            // Create booking seats
            for ($j = 0; $j < $numSeats; $j++) {
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $showtime->screen->seats->random()->id,
                    'price' => $showtime->base_price,
                ]);
            }
        }
    }
} 