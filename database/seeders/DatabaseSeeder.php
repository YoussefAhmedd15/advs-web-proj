<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Showtime;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            MovieSeeder::class,
            ScreenSeeder::class,
            ShowtimeSeeder::class,
        ]);

        // Create admin users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'phone' => '9876543210',
            'is_admin' => true,
        ]);

        // Create regular users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'phone' => '5551234567',
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'phone' => '5559876543',
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob@example.com',
            'password' => Hash::make('password'),
            'phone' => '5554567890',
            'is_admin' => false,
        ]);

        // Create sample movies
        $movies = [
            [
                'title' => 'Inception',
                'genre' => 'Sci-Fi',
                'duration' => 148,
                'synopsis' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_SX300.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/YoHD9XEInc0',
                'rating' => 8.8,
                'is_active' => true
            ],
            [
                'title' => 'The Dark Knight',
                'genre' => 'Action',
                'duration' => 152,
                'synopsis' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BMTMxNTMwODM0NF5BMl5BanBnXkFtZTcwODAyMTk2Mw@@._V1_SX300.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/EXeTwQWrcwY',
                'rating' => 9.0,
                'is_active' => true
            ],
            [
                'title' => 'Pulp Fiction',
                'genre' => 'Crime',
                'duration' => 154,
                'synopsis' => 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BNGNhMDIzZTUtNTBlZi00MTRlLWFjM2ItYzViMjE3YzI5MjljXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SX300.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/s7EdQ4FqbhY',
                'rating' => 8.9,
                'is_active' => true
            ],
            [
                'title' => 'The Shawshank Redemption',
                'genre' => 'Drama',
                'duration' => 142,
                'synopsis' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BNDE3ODcxYzMtY2YzZC00NmNlLWJiNDMtZDViZWM2MzIxZDYwXkEyXkFqcGdeQXVyNjAwNDUxODI@._V1_SX300.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/6hB3S9bIaco',
                'rating' => 9.3,
                'is_active' => true
            ],
            [
                'title' => 'Interstellar',
                'genre' => 'Sci-Fi',
                'duration' => 169,
                'synopsis' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BZjdkOTU3MDktN2IxOS00OGEyLWFmMjktY2FiMmZkNWIyODZiXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_SX300.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/zSWdZVtXT7E',
                'rating' => 8.6,
                'is_active' => true
            ]
        ];

        foreach ($movies as $movie) {
            \App\Models\Movie::create($movie);
        }

        // Create sample screens
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
            \App\Models\Screen::create($screen);
        }

        // Create sample showtimes
        $movies = \App\Models\Movie::all();
        $screens = \App\Models\Screen::all();
        $basePrices = [
            'Screen 1' => 12.00,
            'Screen 2' => 15.00,
            'Screen 3' => 12.00,
            'Screen 4' => 15.00,
            'VIP Screen' => 25.00,
        ];

        // Create showtimes for the next 7 days
        for ($day = 0; $day < 7; $day++) {
            $date = \Carbon\Carbon::now()->addDays($day);
            
            foreach ($movies as $movie) {
                foreach ($screens as $screen) {
                    // Create 3 showtimes per day for each movie-screen combination
                    for ($i = 0; $i < 3; $i++) {
                        $time = $date->copy()->setHour(10 + ($i * 4))->setMinute(0);
                        
                        \App\Models\Showtime::create([
                            'movie_id' => $movie->id,
                            'screen_id' => $screen->id,
                            'time' => $time->format('H:i:s'),
                            'date' => $date->format('Y-m-d'),
                            'price' => $basePrices[$screen->name],
                            'is_active' => true,
                        ]);
                    }
                }
            }
        }
    }
}
