<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    private function convertToEmbedUrl($url)
    {
        // If it's already an embed URL, return as is
        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }

        // Extract video ID from various YouTube URL formats
        $videoId = null;
        
        // Format: https://www.youtube.com/watch?v=VIDEO_ID
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format: https://youtu.be/VIDEO_ID
        elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format: https://www.youtube.com/v/VIDEO_ID
        elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }

        return $url;
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'genre' => ['required', 'string', 'max:255'],
                'duration' => ['required', 'integer', 'min:1'],
                'synopsis' => ['required', 'string'],
                'poster' => ['required', 'string', 'url'],
                'trailer_url' => ['required', 'url'],
                'rating' => ['required', 'numeric', 'min:0', 'max:10'],
                'is_active' => ['boolean'],
            ]);
            
            // Convert YouTube URL to embed format
            $validated['trailer_url'] = $this->convertToEmbedUrl($validated['trailer_url']);
            
            // Set default value for is_active if not provided
            $validated['is_active'] = $request->has('is_active');
            
            // Create the movie
            $movie = Movie::create($validated);

            return redirect()->route('admin.movies.index')
                ->with('success', 'Movie created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating movie', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create movie. ' . $e->getMessage()]);
        }
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {
        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'genre' => ['required', 'string', 'max:255'],
                'duration' => ['required', 'integer', 'min:1'],
                'synopsis' => ['required', 'string'],
                'poster' => ['required', 'string', 'url'],
                'trailer_url' => ['required', 'url'],
                'rating' => ['required', 'numeric', 'min:0', 'max:10'],
                'is_active' => ['boolean'],
            ]);
            
            // Convert YouTube URL to embed format
            $validated['trailer_url'] = $this->convertToEmbedUrl($validated['trailer_url']);
            
            // Set default value for is_active if not provided
            $validated['is_active'] = $request->has('is_active');
            
            // Update the movie
            $movie->update($validated);

            return redirect()->route('admin.movies.index')
                ->with('success', 'Movie updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating movie', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update movie. ' . $e->getMessage()]);
        }
    }

    public function destroy(Movie $movie)
    {
        try {
            // Check if movie has associated showtimes
            if ($movie->showtimes()->count() > 0) {
                return redirect()->route('admin.movies.index')
                    ->with('error', 'Cannot delete movie that has associated showtimes.');
            }
            
            $movie->delete();
            
            return redirect()->route('admin.movies.index')
                ->with('success', 'Movie deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting movie', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('admin.movies.index')
                ->with('error', 'Failed to delete movie. ' . $e->getMessage());
        }
    }
} 