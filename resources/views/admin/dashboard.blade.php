@php
use App\Models\User;
@endphp

@extends('layouts.app')

@section('title', 'Admin Dashboard - Cinema Management System')

@section('content')
<div class="container py-5">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Welcome, {{ Auth::user()->name }}</h4>
                            <p class="mb-0">Manage your cinema system from this dashboard</p>
                        </div>
                        <div>
                            <span class="fs-4">{{ now()->format('l, F j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Admin Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center">
                                    <i class="bi bi-people fs-1 text-primary mb-2"></i>
                                    <h5>User Management</h5>
                                    <p>Add, edit, or remove users and manage their permissions</p>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                        <i class="bi bi-people"></i> Manage Users
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <i class="bi bi-film fs-1 text-success mb-2"></i>
                                    <h5>Movie Management</h5>
                                    <p>Add new movies, update details, or remove old movies</p>
                                    <a href="{{ route('admin.movies.index') }}" class="btn btn-success">
                                        <i class="bi bi-film"></i> Manage Movies
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-info">
                                <div class="card-body text-center">
                                    <i class="bi bi-calendar-event fs-1 text-info mb-2"></i>
                                    <h5>Showtime Management</h5>
                                    <p>Schedule movie showtimes and manage theater availability</p>
                                    <a href="#" class="btn btn-info text-white">
                                        <i class="bi bi-calendar-event"></i> Manage Showtimes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Movies</h5>
                            <h2 class="mb-0">{{ $totalMovies }}</h2>
                        </div>
                        <i class="bi bi-film fs-1 opacity-50"></i>
                    </div>
                    <div class="mt-2 small">{{ $activeMovies }} active movies</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Today's Shows</h5>
                            <h2 class="mb-0">{{ $todayShowtimes->count() }}</h2>
                        </div>
                        <i class="bi bi-calendar-day fs-1 opacity-50"></i>
                    </div>
                    <div class="mt-2 small">{{ now()->format('F j, Y') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Bookings</h5>
                            <h2 class="mb-0">{{ $totalBookings }}</h2>
                        </div>
                        <i class="bi bi-ticket-perforated fs-1 opacity-50"></i>
                    </div>
                    <div class="mt-2 small">${{ number_format($totalRevenue, 2) }} revenue</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Users</h5>
                            <h2 class="mb-0">{{ $totalUsers }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                    <div class="mt-2 small">Excluding {{ User::where('is_admin', true)->count() }} admins</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Top Movies -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Top Movies</h5>
                </div>
                <div class="card-body">
                    @if($topMovies->isEmpty())
                        <p class="text-center">No booking data available yet</p>
                    @else
                        @foreach($topMovies as $movie)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $movie->poster }}" class="me-3" 
                                         style="width: 50px; height: 75px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold">{{ $movie->title }}</div>
                                        <div class="small text-muted">{{ $movie->genre }}</div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-primary">{{ $movie->booking_count }} bookings</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Today's Showtimes -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Today's Showtimes</h5>
                </div>
                <div class="card-body">
                    @if($todayShowtimes->isEmpty())
                        <p class="text-center">No showtimes scheduled for today</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Movie</th>
                                        <th>Time</th>
                                        <th>Screen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todayShowtimes as $showtime)
                                        <tr>
                                            <td>{{ $showtime->movie->title }}</td>
                                            <td>{{ $showtime->time }}</td>
                                            <td>{{ $showtime->screen->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Bookings</h5>
            <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>User</th>
                            <th>Movie</th>
                            <th>Showtime</th>
                            <th>Seats</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $booking->showtime->movie->poster }}" 
                                             class="me-2" 
                                             style="width: 40px; height: 60px; object-fit: cover;">
                                        <span>{{ $booking->showtime->movie->title }}</span>
                                    </div>
                                </td>
                                <td>{{ $booking->showtime->time }} ({{ $booking->showtime->date->format('M d') }})</td>
                                <td>{{ $booking->seat_number }}</td>
                                <td>${{ number_format($booking->amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No recent bookings</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection 