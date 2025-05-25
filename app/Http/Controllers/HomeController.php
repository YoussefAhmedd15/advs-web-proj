<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured movie (most recent active movie)
        $featuredMovie = Movie::where('is_active', true)
            ->latest()
            ->first();

        // Get upcoming movies (active movies)
        $upcomingMovies = Movie::where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('featuredMovie', 'upcomingMovies'));
    }
} 