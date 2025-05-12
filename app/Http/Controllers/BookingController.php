<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'movie_id' => ['required'],
            'showtime_id' => ['required'],
            'seats' => ['required', 'json'],
        ]);

        // In a real application, you would create a booking here
        // For this demo, we'll just redirect to dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Booking successful!');
    }

    public function show($id)
    {
        // In a real application, you would fetch the booking details here
        // For this demo, we'll just redirect to dashboard
        return redirect()->route('dashboard');
    }

    public function cancel($id)
    {
        // In a real application, you would cancel the booking here
        // For this demo, we'll just redirect to dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Booking cancelled successfully!');
    }
} 