<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Static user data
        $user = [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];

        // Static booking data
        $bookings = [
            [
                'id' => 1,
                'movie_title' => 'The Dark Knight',
                'movie_poster' => 'https://example.com/dark-knight.jpg',
                'genre' => 'Action',
                'duration' => 152,
                'showtime' => '19:00',
                'date' => '2024-03-15',
                'hall' => 'Hall A',
                'seats' => ['A1', 'A2'],
                'amount' => 24.00,
                'status' => 'Confirmed',
                'status_color' => 'success',
                'can_cancel' => true
            ],
            [
                'id' => 2,
                'movie_title' => 'Inception',
                'movie_poster' => 'https://example.com/inception.jpg',
                'genre' => 'Sci-Fi',
                'duration' => 148,
                'showtime' => '20:00',
                'date' => '2024-03-20',
                'hall' => 'Hall B',
                'seats' => ['B3'],
                'amount' => 12.00,
                'status' => 'Pending',
                'status_color' => 'warning',
                'can_cancel' => true
            ]
        ];

        // Static stats
        $upcomingShows = 2;
        $rewardPoints = 150;

        return view('dashboard', compact('user', 'bookings', 'upcomingShows', 'rewardPoints'));
    }
} 