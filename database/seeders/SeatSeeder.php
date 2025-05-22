<?php

namespace Database\Seeders;

use App\Models\Screen;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        $screens = Screen::all();

        foreach ($screens as $screen) {
            for ($row = 1; $row <= $screen->rows; $row++) {
                for ($col = 1; $col <= $screen->seats_per_row; $col++) {
                    // Determine seat type based on row
                    $type = 'regular';
                    $price_multiplier = 1.00;

                    if ($screen->name === 'VIP Screen') {
                        $type = 'vip';
                        $price_multiplier = 2.00;
                    } elseif ($row <= 2) {
                        $type = 'vip';
                        $price_multiplier = 1.50;
                    } elseif ($row >= $screen->rows - 1) {
                        $type = 'couple';
                        $price_multiplier = 1.25;
                    }

                    Seat::create([
                        'screen_id' => $screen->id,
                        'seat_number' => chr(64 + $row) . $col,
                        'row_number' => $row,
                        'column_number' => $col,
                        'type' => $type,
                        'price_multiplier' => $price_multiplier,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
} 