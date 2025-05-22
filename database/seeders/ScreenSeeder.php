<?php

namespace Database\Seeders;

use App\Models\Screen;
use Illuminate\Database\Seeder;

class ScreenSeeder extends Seeder
{
    public function run(): void
    {
        $screens = [
            [
                'name' => 'Screen 1',
                'total_seats' => 100,
                'rows' => 10,
                'seats_per_row' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Screen 2',
                'total_seats' => 150,
                'rows' => 15,
                'seats_per_row' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'VIP Screen',
                'total_seats' => 50,
                'rows' => 5,
                'seats_per_row' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($screens as $screen) {
            Screen::create($screen);
        }
    }
} 