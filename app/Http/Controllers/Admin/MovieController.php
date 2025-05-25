<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('genre', 'like', "%{$searchTerm}%");
            });
        }
        
        // Genre filtering
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }
        
        // Status filtering
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        // Sorting
        switch ($request->sort) {
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $movies = $query->paginate(10);
        
        // Get unique genres for the filter dropdown
        $genres = Movie::distinct('genre')->pluck('genre');
        
        return view('admin.movies.index', compact('movies', 'genres'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        // Log the incoming request data
        Log::info('Movie store method called', [
            'request_data' => $request->all()
        ]);

        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'genre' => ['required', 'string', 'max:255'],
                'duration' => ['required', 'integer', 'min:1'],
                'poster' => ['required', 'url'],
                'trailer_url' => ['required', 'url'],
                'synopsis' => ['required', 'string'],
                'rating' => ['nullable', 'numeric', 'min:0', 'max:10'],
                'is_active' => ['boolean'],
            ]);
            
            // Log the validated data
            Log::info('Validation passed', [
                'validated_data' => $validated
            ]);
            
            // Set default value for is_active if not provided
            $validated['is_active'] = $request->has('is_active');
            
            // Create the movie
            $movie = Movie::create($validated);
            
            // Log the created movie
            Log::info('Movie created successfully', [
                'movie' => $movie
            ]);

            return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully!');
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error creating movie', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()->withErrors(['error' => 'Failed to create movie. ' . $e->getMessage()]);
        }
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1'],
            'poster' => ['required', 'url'],
            'trailer_url' => ['required', 'url'],
            'synopsis' => ['required', 'string'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'is_active' => ['boolean'],
        ]);
        
        // Set default value for is_active if not provided
        $validated['is_active'] = $request->has('is_active');
        
        // Update the movie
        $movie->update($validated);

        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully!');
    }

    public function destroy(Movie $movie)
    {
        // Check if movie has associated showtimes
        if ($movie->showtimes()->count() > 0) {
            return redirect()->route('admin.movies.index')
                ->with('error', 'Cannot delete movie that has associated showtimes.');
        }
        
        $movie->delete();
        
        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully!');
    }
} 