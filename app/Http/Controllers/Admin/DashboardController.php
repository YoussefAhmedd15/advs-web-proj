<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Static stats
        $totalMovies = 15;
        $todayShows = 8;
        $totalBookings = 150;
        $totalRevenue = 1800.00;

        // Static recent bookings
        $recentBookings = [
            [
                'id' => 1,
                'movie_title' => 'The Dark Knight',
                'movie_poster' => 'https://example.com/dark-knight.jpg',
                'showtime' => '19:00',
                'seats' => ['A1', 'A2'],
                'status' => 'Confirmed',
                'status_color' => 'success'
            ],
            [
                'id' => 2,
                'movie_title' => 'Inception',
                'movie_poster' => 'https://example.com/inception.jpg',
                'showtime' => '20:00',
                'seats' => ['B3'],
                'status' => 'Pending',
                'status_color' => 'warning'
            ]
        ];

        return view('admin.dashboard', compact(
            'totalMovies',
            'todayShows',
            'totalBookings',
            'totalRevenue',
            'recentBookings'
        ));
    }
} 