<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Featured movie
        $featuredMovie = [
            'title' => 'The Dark Knight',
            'genre' => 'Action',
            'duration' => 152,
            'rating' => 4.5,
            'poster' => 'https://m.media-amazon.com/images/M/MV5BMTMxNTMwODM0NF5BMl5BanBnXkFtZTcwODAyMTk2Mw@@._V1_.jpg',
            'synopsis' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
            'trailer_url' => 'https://www.youtube.com/embed/EXeTwQWrcwY'
        ];

        // Upcoming movies
        $upcomingMovies = [
            [
                'title' => 'Inception',
                'genre' => 'Sci-Fi',
                'duration' => 148,
                'rating' => 4.8,
                'poster' => 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_.jpg',
                'release_date' => '2024-03-20'
            ],
            [
                'title' => 'The Shawshank Redemption',
                'genre' => 'Drama',
                'duration' => 142,
                'rating' => 4.9,
                'poster' => 'https://m.media-amazon.com/images/M/MV5BNDE3ODcxYzMtY2YzZC00NmNlLWJiNDMtZDViZWM2MzIxZDYwXkEyXkFqcGdeQXVyNjAwNDUxODI@._V1_.jpg',
                'release_date' => '2024-03-25'
            ],
            [
                'title' => 'Pulp Fiction',
                'genre' => 'Crime',
                'duration' => 154,
                'rating' => 4.7,
                'poster' => 'https://m.media-amazon.com/images/M/MV5BNGNhMDIzZTUtNTBlZi00MTRlLWFjM2ItYzViMjE3YzI5MjljXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg',
                'release_date' => '2024-03-30'
            ]
        ];

        return view('home', compact('featuredMovie', 'upcomingMovies'));
    }
} 