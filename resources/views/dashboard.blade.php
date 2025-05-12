@extends('layouts.app')

@section('title', 'Dashboard - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- User Profile -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Profile Information</h5>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <p class="form-control-static">{{ $user['name'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <p class="form-control-static">{{ $user['email'] }}</p>
                    </div>
                    <a href="#" class="btn btn-outline-primary">Edit Profile</a>
                </div>
            </div>

            <!-- Stats -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Your Stats</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Upcoming Shows</span>
                        <span class="badge bg-primary">{{ $upcomingShows }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Reward Points</span>
                        <span class="badge bg-success">{{ $rewardPoints }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Your Bookings</h5>
                    
                    @forelse($bookings as $booking)
                        <div class="booking-item mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ $booking['movie_poster'] }}" 
                                         class="img-fluid rounded" 
                                         alt="{{ $booking['movie_title'] }}">
                                </div>
                                <div class="col-md-9">
                                    <h6>{{ $booking['movie_title'] }}</h6>
                                    <p class="mb-2">
                                        <span class="badge bg-primary">{{ $booking['genre'] }}</span>
                                        <span class="text-muted">{{ $booking['duration'] }} min</span>
                                    </p>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <small class="text-muted">Showtime</small>
                                            <p class="mb-0">{{ $booking['showtime'] }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">Date</small>
                                            <p class="mb-0">{{ $booking['date'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <small class="text-muted">Hall</small>
                                            <p class="mb-0">{{ $booking['hall'] }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">Seats</small>
                                            <p class="mb-0">{{ implode(', ', $booking['seats']) }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-{{ $booking['status_color'] }}">
                                                {{ $booking['status'] }}
                                            </span>
                                            <span class="ms-2">${{ number_format($booking['amount'], 2) }}</span>
                                        </div>
                                        @if($booking['can_cancel'])
                                            <form action="{{ route('booking.cancel', $booking['id']) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                    Cancel Booking
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            You haven't made any bookings yet.
                            <a href="{{ route('movies.index') }}" class="alert-link">Browse movies</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection 