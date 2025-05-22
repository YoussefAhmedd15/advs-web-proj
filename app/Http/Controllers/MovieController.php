<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::where('is_active', true)
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        if (!$movie->is_active) {
            abort(404);
        }

        $movie->load('showtimes.screen');
        
        return view('movies.show', compact('movie'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $movies = Movie::where('is_active', true)
                      ->where(function($q) use ($query) {
                          $q->where('title', 'like', "%{$query}%")
                            ->orWhere('genre', 'like', "%{$query}%")
                            ->orWhere('synopsis', 'like', "%{$query}%");
                      })
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('movies.index', compact('movies', 'query'));
    }
} 