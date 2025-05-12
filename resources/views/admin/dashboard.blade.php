@extends('layouts.app')

@section('title', 'Admin Dashboard - Cinema Management System')

@section('content')
<div class="container py-5">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Movies</h5>
                    <h2 class="mb-0">{{ $totalMovies }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Today's Shows</h5>
                    <h2 class="mb-0">{{ $todayShows }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings</h5>
                    <h2 class="mb-0">{{ $totalBookings }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <h2 class="mb-0">${{ number_format($totalRevenue, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Bookings</h5>
            <a href="{{ route('admin.movies.index') }}" class="btn btn-primary btn-sm">Manage Movies</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Movie</th>
                            <th>Showtime</th>
                            <th>Seats</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                            <tr>
                                <td>#{{ $booking['id'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $booking['movie_poster'] }}" 
                                             class="me-2" 
                                             style="width: 40px; height: 60px; object-fit: cover;">
                                        <span>{{ $booking['movie_title'] }}</span>
                                    </div>
                                </td>
                                <td>{{ $booking['showtime'] }}</td>
                                <td>{{ implode(', ', $booking['seats']) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking['status_color'] }}">
                                        {{ $booking['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No recent bookings</td>
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