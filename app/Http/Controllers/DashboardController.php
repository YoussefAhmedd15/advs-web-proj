<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's bookings with relationships
        $bookings = Booking::with(['showtime.movie', 'showtime.screen'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Count upcoming shows
        $upcomingShows = Showtime::where('date', '>=', now()->format('Y-m-d'))
            ->where('is_active', true)
            ->count();

        // Calculate reward points (example: 10 points per booking)
        $rewardPoints = $bookings->count() * 10;

        return view('dashboard', compact('user', 'bookings', 'upcomingShows', 'rewardPoints'));
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'confirmed' => 'success',
            'pending' => 'warning',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }
} 