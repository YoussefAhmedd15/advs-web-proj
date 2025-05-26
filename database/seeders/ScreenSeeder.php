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
                'capacity' => 100,
                'description' => 'Standard screen with comfortable seating',
                'is_active' => true
            ],
            [
                'name' => 'Screen 2',
                'capacity' => 150,
                'description' => 'Large screen with premium sound system',
                'is_active' => true
            ],
            [
                'name' => 'Screen 3',
                'capacity' => 80,
                'description' => 'Intimate screening room',
                'is_active' => true
            ],
            [
                'name' => 'Screen 4',
                'capacity' => 120,
                'description' => 'Modern screen with 3D capability',
                'is_active' => true
            ],
            [
                'name' => 'VIP Screen',
                'capacity' => 50,
                'description' => 'Luxury screening room with premium amenities',
                'is_active' => true
            ]
        ];

        foreach ($screens as $screen) {
            Screen::create($screen);
        }
    }
} 