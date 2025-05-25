<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::where('is_active', true);

        // Handle genre filter
        if ($request->input('genre') && $request->input('genre') !== 'All Genres') {
            $query->where('genre', $request->input('genre'));
        }

        // Handle search query
        $searchQuery = $request->input('query');
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                  ->orWhere('synopsis', 'like', '%' . $searchQuery . '%');
            });
        }

        $movies = $query->orderBy('created_at', 'desc')->paginate(9);

        // Get unique genres for the filter dropdown
        $genres = Movie::distinct()->pluck('genre')->filter()->values();

        return view('movies.index', compact('movies', 'genres'));
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
        return $this->index($request);
    }
} 