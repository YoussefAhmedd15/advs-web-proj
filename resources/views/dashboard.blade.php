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
                        <p class="form-control-static">{{ $user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <p class="form-control-static">{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <p class="form-control-static">{{ $user->phone }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Edit Profile</a>
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
                <div class="card-header">
                    <h5 class="mb-0">Your Bookings</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($bookings->isEmpty())
                        <div class="alert alert-info">
                            You haven't made any bookings yet.
                            <a href="{{ route('movies.index') }}" class="alert-link">Browse movies</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Movie</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Screen</th>
                                        <th>Tickets</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $booking->showtime->movie->poster }}" 
                                                        alt="{{ $booking->showtime->movie->title }}" 
                                                        class="img-thumbnail me-2" style="width: 50px;">
                                                    {{ $booking->showtime->movie->title }}
                                                </div>
                                            </td>
                                            <td>{{ $booking->showtime->date ?? 'N/A' }}</td>
                                            <td>{{ $booking->showtime->time ?? 'N/A' }}</td>
                                            <td>{{ $booking->showtime->screen->name }}</td>
                                            <td>{{ $booking->number_of_tickets }}</td>
                                            <td>
                                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('bookings.show', $booking) }}" 
                                                    class="btn btn-sm btn-primary">View</a>
                                                @if($booking->status === 'confirmed')
                                                    <form action="{{ route('bookings.cancel', $booking) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.booking-card {
    transition: all 0.3s ease;
}
.booking-card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
</style>
@endsection 