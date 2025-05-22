<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Screen;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShowtimeSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::all();
        $screens = Screen::all();
        $basePrices = [
            'Screen 1' => 12.00,
            'Screen 2' => 15.00,
            'VIP Screen' => 25.00,
        ];

        // Create showtimes for the next 7 days
        for ($day = 0; $day < 7; $day++) {
            $date = Carbon::now()->addDays($day);
            
            foreach ($movies as $movie) {
                foreach ($screens as $screen) {
                    // Create 3 showtimes per day for each movie-screen combination
                    for ($i = 0; $i < 3; $i++) {
                        $startTime = $date->copy()->setHour(10 + ($i * 4))->setMinute(0);
                        $endTime = $startTime->copy()->addMinutes($movie->duration_minutes + 20); // Add 20 minutes for cleaning

                        Showtime::create([
                            'movie_id' => $movie->id,
                            'screen_id' => $screen->id,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'base_price' => $basePrices[$screen->name],
                            'is_active' => true,
                        ]);
                    }
                }
            }
        }
    }
} 