<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private $movies;

    public function __construct()
    {
        // Static movie data
        $this->movies = [
            [
                'id' => 1,
                'title' => 'The Dark Knight',
                'genre' => 'Action',
                'duration' => 152,
                'poster' => 'https://example.com/dark-knight.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/EXeTwQWrcwY',
                'synopsis' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'status' => 'Now Showing',
                'status_color' => 'success'
            ],
            [
                'id' => 2,
                'title' => 'Inception',
                'genre' => 'Sci-Fi',
                'duration' => 148,
                'poster' => 'https://example.com/inception.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/YoHD9XEInc0',
                'synopsis' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'status' => 'Coming Soon',
                'status_color' => 'warning'
            ]
        ];
    }

    public function index()
    {
        $movies = $this->movies;
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1'],
            'poster' => ['required', 'url'],
            'trailer_url' => ['required', 'url'],
            'synopsis' => ['required', 'string'],
            'status' => ['required', 'in:now_showing,coming_soon,ended'],
        ]);

        // In a real application, you would create a movie here
        // For this demo, we'll just redirect to the movies list with a success message
        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully!');
    }

    public function edit($id)
    {
        $movie = collect($this->movies)->firstWhere('id', $id);
        if (!$movie) {
            abort(404);
        }

        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1'],
            'poster' => ['required', 'url'],
            'trailer_url' => ['required', 'url'],
            'synopsis' => ['required', 'string'],
            'status' => ['required', 'in:now_showing,coming_soon,ended'],
        ]);

        // In a real application, you would update the movie here
        // For this demo, we'll just redirect to the movies list with a success message
        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully!');
    }

    public function destroy($id)
    {
        // In a real application, you would delete the movie here
        // For this demo, we'll just redirect to the movies list with a success message
        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully!');
    }
} 