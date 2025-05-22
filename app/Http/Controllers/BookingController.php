<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
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
                'showtimes' => [
                    [
                        'id' => 1,
                        'time' => '19:00',
                        'hall' => 'Hall A',
                        'occupied_seats' => ['A1', 'A2', 'B3', 'C4']
                    ]
                ]
            ]
        ];
    }

    public function create(Request $request)
    {
        $movieId = $request->input('movie');
        $showtimeId = $request->input('showtime');

        $movie = collect($this->movies)->firstWhere('id', $movieId);
        if (!$movie) {
            abort(404);
        }

        $showtime = collect($movie['showtimes'])->firstWhere('id', $showtimeId);
        if (!$showtime) {
            abort(404);
        }

        $pricePerTicket = 12.00; // Static price per ticket

        return view('booking.create', compact('movie', 'showtime', 'pricePerTicket'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seat_number' => 'required|string',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'showtime_id' => $validated['showtime_id'],
            'seat_number' => $validated['seat_number'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'status' => 'confirmed'
        ]);

        return redirect()->route('bookings.confirmation', $booking)
            ->with('success', 'Booking confirmed successfully!');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        return view('bookings.show', compact('booking'));
    }

    public function showMovieSelection()
    {
        $movies = Movie::with('showtimes')->get();
        return view('bookings.movies', compact('movies'));
    }

    public function showShowtimeSelection(Movie $movie, Showtime $showtime)
    {
        return view('bookings.showtimes', compact('movie', 'showtime'));
    }

    public function showSeatSelection(Showtime $showtime)
    {
        $bookedSeats = $showtime->bookings()->pluck('seat_number')->toArray();
        return view('bookings.seats', compact('showtime', 'bookedSeats'));
    }

    public function showConfirmation(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        return view('bookings.confirmation', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        $booking->delete();
        return redirect()->route('dashboard')->with('success', 'Booking cancelled successfully.');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('dashboard')->with('success', 'Booking cancelled successfully.');
    }
} 