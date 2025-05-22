<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run()
    {
        $movies = [
            [
                'title' => 'Inception',
                'genre' => 'Sci-Fi',
                'duration' => 148,
                'synopsis' => 'A thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/YoHD9XEInc0',
                'rating' => 8.8,
                'is_active' => true
            ],
            [
                'title' => 'The Dark Knight',
                'genre' => 'Action',
                'duration' => 152,
                'synopsis' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BMTMxNTMwODM0NF5BMl5BanBnXkFtZTcwODAyMTk2Mw@@._V1_.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/EXeTwQWrcwY',
                'rating' => 9.0,
                'is_active' => true
            ],
            [
                'title' => 'Interstellar',
                'genre' => 'Adventure',
                'duration' => 169,
                'synopsis' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BZjdkOTU3MDktN2IxOS00OGEyLWFmMjktY2FiMmZkNWIyODZiXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/2LqzF5WauAw',
                'rating' => 8.6,
                'is_active' => true
            ],
            [
                'title' => 'The Shawshank Redemption',
                'genre' => 'Drama',
                'duration' => 142,
                'synopsis' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BNDE3ODcxYzMtY2YzZC00NmNlLWJiNDMtZDViZWM2MzIxZDYwXkEyXkFqcGdeQXVyNjAwNDUxODI@._V1_.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/6hB3S9bIaco',
                'rating' => 9.3,
                'is_active' => true
            ]
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
} 