<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShowtimeController extends Controller
{
    public function index(Request $request)
    {
        $query = Showtime::with(['movie', 'screen']);

        // Filter by movie
        if ($request->filled('movie_id')) {
            $query->where('movie_id', $request->movie_id);
        }

        // Filter by screen
        if ($request->filled('screen_id')) {
            $query->where('screen_id', $request->screen_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Sort by date and time
        $query->orderBy('date')->orderBy('time');

        $showtimes = $query->paginate(10);
        $movies = Movie::where('is_active', true)->get();
        $screens = Screen::all();

        return view('admin.showtimes.index', compact('showtimes', 'movies', 'screens'));
    }

    public function create()
    {
        $movies = Movie::where('is_active', true)->get();
        $screens = Screen::all();
        return view('admin.showtimes.create', compact('movies', 'screens'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'movie_id' => ['required', 'exists:movies,id'],
                'screen_id' => ['required', 'exists:screens,id'],
                'date' => ['required', 'date', 'after_or_equal:today'],
                'time' => ['required', 'date_format:H:i'],
            ]);

            // Check for screen availability
            $conflictingShowtime = Showtime::where('screen_id', $validated['screen_id'])
                ->where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->first();

            if ($conflictingShowtime) {
                return back()
                    ->withInput()
                    ->withErrors(['time' => 'This screen is already booked for the selected date and time.']);
            }

            // Get movie duration
            $movie = Movie::findOrFail($validated['movie_id']);
            
            // Check for overlapping showtimes
            $overlappingShowtime = Showtime::where('screen_id', $validated['screen_id'])
                ->where('date', $validated['date'])
                ->where(function ($query) use ($validated, $movie) {
                    $showtimeStart = strtotime($validated['time']);
                    $showtimeEnd = $showtimeStart + ($movie->duration * 60);
                    
                    $query->where(function ($q) use ($showtimeStart, $showtimeEnd) {
                        $q->whereRaw('UNIX_TIMESTAMP(time) BETWEEN ? AND ?', [$showtimeStart, $showtimeEnd])
                          ->orWhereRaw('UNIX_TIMESTAMP(time) + (duration * 60) BETWEEN ? AND ?', [$showtimeStart, $showtimeEnd]);
                    });
                })
                ->first();

            if ($overlappingShowtime) {
                return back()
                    ->withInput()
                    ->withErrors(['time' => 'This showtime overlaps with an existing showtime.']);
            }

            $showtime = Showtime::create($validated);

            return redirect()->route('admin.showtimes.index')
                ->with('success', 'Showtime created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating showtime', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create showtime. ' . $e->getMessage()]);
        }
    }

    public function edit(Showtime $showtime)
    {
        $movies = Movie::where('is_active', true)->get();
        $screens = Screen::all();
        return view('admin.showtimes.edit', compact('showtime', 'movies', 'screens'));
    }

    public function update(Request $request, Showtime $showtime)
    {
        try {
            $validated = $request->validate([
                'movie_id' => ['required', 'exists:movies,id'],
                'screen_id' => ['required', 'exists:screens,id'],
                'date' => ['required', 'date', 'after_or_equal:today'],
                'time' => ['required', 'date_format:H:i'],
            ]);

            // Check for screen availability (excluding current showtime)
            $conflictingShowtime = Showtime::where('screen_id', $validated['screen_id'])
                ->where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->where('id', '!=', $showtime->id)
                ->first();

            if ($conflictingShowtime) {
                return back()
                    ->withInput()
                    ->withErrors(['time' => 'This screen is already booked for the selected date and time.']);
            }

            // Get movie duration
            $movie = Movie::findOrFail($validated['movie_id']);
            
            // Check for overlapping showtimes (excluding current showtime)
            $overlappingShowtime = Showtime::where('screen_id', $validated['screen_id'])
                ->where('date', $validated['date'])
                ->where('id', '!=', $showtime->id)
                ->where(function ($query) use ($validated, $movie) {
                    $showtimeStart = strtotime($validated['time']);
                    $showtimeEnd = $showtimeStart + ($movie->duration * 60);
                    
                    $query->where(function ($q) use ($showtimeStart, $showtimeEnd) {
                        $q->whereRaw('UNIX_TIMESTAMP(time) BETWEEN ? AND ?', [$showtimeStart, $showtimeEnd])
                          ->orWhereRaw('UNIX_TIMESTAMP(time) + (duration * 60) BETWEEN ? AND ?', [$showtimeStart, $showtimeEnd]);
                    });
                })
                ->first();

            if ($overlappingShowtime) {
                return back()
                    ->withInput()
                    ->withErrors(['time' => 'This showtime overlaps with an existing showtime.']);
            }

            $showtime->update($validated);

            return redirect()->route('admin.showtimes.index')
                ->with('success', 'Showtime updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating showtime', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update showtime. ' . $e->getMessage()]);
        }
    }

    public function destroy(Showtime $showtime)
    {
        try {
            // Check if showtime has any bookings
            if ($showtime->bookings()->exists()) {
                return redirect()->route('admin.showtimes.index')
                    ->with('error', 'Cannot delete showtime that has associated bookings.');
            }

            $showtime->delete();

            return redirect()->route('admin.showtimes.index')
                ->with('success', 'Showtime deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting showtime', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.showtimes.index')
                ->with('error', 'Failed to delete showtime. ' . $e->getMessage());
        }
    }
} 