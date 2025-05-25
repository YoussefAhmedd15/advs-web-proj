<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\User;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Get basic statistics
        $totalMovies = Movie::count();
        $totalUsers = User::where('is_admin', false)->count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('amount') ?? 0;

        // Get active movies
        $activeMovies = Movie::where('is_active', true)->count();
        
        // Get recent bookings
        $recentBookings = Booking::with(['user', 'showtime.movie'])
            ->latest()
            ->take(5)
            ->get();
            
        // Get today's showtimes
        $todayShowtimes = Showtime::with('movie')
            ->whereDate('date', Carbon::today())
            ->orderBy('time')
            ->get();
            
        // Get bookings for the last 7 days for chart
        $lastWeekBookings = Booking::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Get user registrations for the last 7 days
        $lastWeekUsers = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Get top movies by bookings
        $topMovies = Movie::select('movies.*', DB::raw('COUNT(bookings.id) as booking_count'))
            ->leftJoin('showtimes', 'movies.id', '=', 'showtimes.movie_id')
            ->leftJoin('bookings', 'showtimes.id', '=', 'bookings.showtime_id')
            ->groupBy('movies.id')
            ->orderByDesc('booking_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMovies',
            'totalUsers',
            'totalBookings',
            'totalRevenue',
            'activeMovies',
            'recentBookings',
            'todayShowtimes',
            'lastWeekBookings',
            'lastWeekUsers',
            'topMovies'
        ));
    }
} 