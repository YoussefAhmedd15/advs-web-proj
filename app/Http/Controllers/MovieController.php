<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    private $movies;

    public function __construct()
    {
        // Static data for all movies
        $this->movies = [
            [
                'id' => 1,
                'title' => 'The Dark Knight',
                'genre' => 'Action',
                'release_date' => '2024-03-15',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BMTMxNTMwODM0NF5BMl5BanBnXkFtZTcwODAyMTk2Mw@@._V1_.jpg',
                'duration' => 152,
                'rating' => 4.5,
                'synopsis' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'cast' => ['Christian Bale', 'Heath Ledger', 'Aaron Eckhart'],
                'trailer_url' => 'https://www.youtube.com/embed/EXeTwQWrcwY',
                'showtimes' => [
                    ['id' => 1, 'time' => '10:00', 'hall' => 'Hall A'],
                    ['id' => 2, 'time' => '13:00', 'hall' => 'Hall B'],
                    ['id' => 3, 'time' => '16:00', 'hall' => 'Hall A'],
                    ['id' => 4, 'time' => '19:00', 'hall' => 'Hall B'],
                ]
            ],
            [
                'id' => 2,
                'title' => 'Inception',
                'genre' => 'Sci-Fi',
                'release_date' => '2024-03-20',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_.jpg',
                'duration' => 148,
                'rating' => 4.8,
                'synopsis' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'cast' => ['Leonardo DiCaprio', 'Joseph Gordon-Levitt', 'Ellen Page'],
                'trailer_url' => 'https://www.youtube.com/embed/YoHD9XEInc0',
                'showtimes' => [
                    ['id' => 5, 'time' => '11:00', 'hall' => 'Hall A'],
                    ['id' => 6, 'time' => '14:00', 'hall' => 'Hall B'],
                    ['id' => 7, 'time' => '17:00', 'hall' => 'Hall A'],
                    ['id' => 8, 'time' => '20:00', 'hall' => 'Hall B'],
                ]
            ],
            [
                'id' => 3,
                'title' => 'The Shawshank Redemption',
                'genre' => 'Drama',
                'release_date' => '2024-03-25',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BNDE3ODcxYzMtY2YzZC00NmNlLWJiNDMtZDViZWM2MzIxZDYwXkEyXkFqcGdeQXVyNjAwNDUxODI@._V1_.jpg',
                'duration' => 142,
                'rating' => 4.9,
                'synopsis' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'cast' => ['Tim Robbins', 'Morgan Freeman', 'Bob Gunton'],
                'trailer_url' => 'https://www.youtube.com/embed/6hB3S9bIaco',
                'showtimes' => [
                    ['id' => 9, 'time' => '12:00', 'hall' => 'Hall A'],
                    ['id' => 10, 'time' => '15:00', 'hall' => 'Hall B'],
                    ['id' => 11, 'time' => '18:00', 'hall' => 'Hall A'],
                    ['id' => 12, 'time' => '21:00', 'hall' => 'Hall B'],
                ]
            ],
            [
                'id' => 4,
                'title' => 'Pulp Fiction',
                'genre' => 'Crime',
                'release_date' => '2024-03-30',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BNGNhMDIzZTUtNTBlZi00MTRlLWFjM2ItYzViMjE3YzI5MjljXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg',
                'duration' => 154,
                'rating' => 4.7,
                'synopsis' => 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
                'cast' => ['John Travolta', 'Uma Thurman', 'Samuel L. Jackson'],
                'trailer_url' => 'https://www.youtube.com/embed/s7EdQ4FqbhY',
                'showtimes' => [
                    ['id' => 13, 'time' => '10:30', 'hall' => 'Hall A'],
                    ['id' => 14, 'time' => '13:30', 'hall' => 'Hall B'],
                    ['id' => 15, 'time' => '16:30', 'hall' => 'Hall A'],
                    ['id' => 16, 'time' => '19:30', 'hall' => 'Hall B'],
                ]
            ]
        ];
    }

    public function index()
    {
        $movies = $this->movies;
        return view('movies.index', compact('movies'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $genre = $request->input('genre');

        $movies = collect($this->movies)->filter(function ($movie) use ($query, $genre) {
            $matchesQuery = empty($query) || 
                stripos($movie['title'], $query) !== false || 
                stripos($movie['synopsis'], $query) !== false;
            
            $matchesGenre = empty($genre) || $movie['genre'] === $genre;

            return $matchesQuery && $matchesGenre;
        })->values();

        return view('movies.index', compact('movies', 'query', 'genre'));
    }

    public function show($movie)
    {
        // Always show the first movie (The Dark Knight) regardless of the ID
        $movie = $this->movies[0];
        return view('movies.show', compact('movie'));
    }
} 