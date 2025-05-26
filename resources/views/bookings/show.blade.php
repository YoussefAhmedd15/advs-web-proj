@extends('layouts.app')

@section('title', 'Booking Details - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Booking Details</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <img src="{{ $booking->showtime->movie->poster }}" 
                                alt="{{ $booking->showtime->movie->title }}" 
                                class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $booking->showtime->movie->title }}</h4>
                            <p class="text-muted">{{ $booking->showtime->movie->description }}</p>
                            
                            <div class="row mt-3">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Date:</strong></p>
                                    <p>{{ $booking->showtime->date ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><strong>Time:</strong></p>
                                    <p>{{ $booking->showtime->time ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Screen:</strong></p>
                                    <p>{{ $booking->showtime->screen->name }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><strong>Status:</strong></p>
                                    <p>
                                        <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Number of Tickets:</strong></p>
                                    <p>{{ $booking->number_of_tickets }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                        
                        @if($booking->status === 'confirmed')
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    Cancel Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 14px;
    }

    .payment-form {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
    }

    .payment-form input {
        font-size: 16px;
    }

    .payment-form input::placeholder {
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format card number input
    const cardNumber = document.getElementById('card_number');
    if (cardNumber) {
        cardNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})/g, '$1 ').trim();
            e.target.value = value;
        });
    }

    // Format expiry date input
    const expiry = document.getElementById('expiry');
    if (expiry) {
        expiry.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0,2) + '/' + value.slice(2,4);
            }
            e.target.value = value;
        });
    }

    // Format CVV input
    const cvv = document.getElementById('cvv');
    if (cvv) {
        cvv.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0,3);
        });
    }
});
</script>
@endpush
@endsection 