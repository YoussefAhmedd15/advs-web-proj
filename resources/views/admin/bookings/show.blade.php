@extends('layouts.app')

@section('title', 'Booking Details - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Booking Details</h4>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <div class="booking-status mb-4">
                        <div class="status-badge {{ $booking->status === 'confirmed' ? 'bg-success' : ($booking->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($booking->status) }}
                        </div>
                    </div>

                    <div class="movie-details mb-4">
                        <h5>Movie Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ $booking->showtime->movie->poster }}" alt="{{ $booking->showtime->movie->title }}" class="img-fluid rounded">
                            </div>
                            <div class="col-md-8">
                                <h4>{{ $booking->showtime->movie->title }}</h4>
                                <p class="mb-1"><strong>Genre:</strong> {{ $booking->showtime->movie->genre }}</p>
                                <p class="mb-1"><strong>Duration:</strong> {{ $booking->showtime->movie->duration }} minutes</p>
                                <p class="mb-1"><strong>Rating:</strong> {{ $booking->showtime->movie->rating }}/10</p>
                            </div>
                        </div>
                    </div>

                    <div class="showtime-details mb-4">
                        <h5>Showtime Information</h5>
                        <p class="mb-1"><strong>Date:</strong> {{ $booking->showtime->date ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Time:</strong> {{ $booking->showtime->time ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Screen:</strong> {{ $booking->showtime->screen->name }}</p>
                    </div>

                    <div class="booking-details mb-4">
                        <h5>Booking Information</h5>
                        <p class="mb-1"><strong>Confirmation Code:</strong> {{ $booking->confirmation_code }}</p>
                        <p class="mb-1"><strong>Booking ID:</strong> {{ $booking->id }}</p>
                        <p class="mb-1"><strong>Booked Seats:</strong> {{ $booking->seats->pluck('seat_number')->implode(', ') }}</p>
                        <p class="mb-1"><strong>Total Amount:</strong> ${{ number_format($booking->total_amount, 2) }}</p>
                        <p class="mb-1"><strong>Payment Status:</strong> {{ ucfirst($booking->payment_status) }}</p>
                        <p class="mb-1"><strong>Booking Date:</strong> {{ $booking->created_at ?? 'N/A' }}</p>
                    </div>

                    <div class="customer-details mb-4">
                        <h5>Customer Information</h5>
                        <p class="mb-1"><strong>Name:</strong> {{ $booking->customer_name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $booking->customer_email }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $booking->customer_phone }}</p>
                    </div>

                    <div class="update-booking mb-4">
                        <h5>Update Booking</h5>
                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="payment_status" class="form-label">Payment Status</label>
                                        <select name="payment_status" id="payment_status" class="form-select">
                                            <option value="pending" {{ $booking->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="refunded" {{ $booking->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Booking</button>
                        </form>
                    </div>

                    <div class="delete-booking">
                        <h5>Delete Booking</h5>
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                                Delete Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 