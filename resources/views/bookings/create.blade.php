@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Book Tickets</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <img src="{{ $showtime->movie->poster }}" alt="{{ $showtime->movie->title }}" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title">{{ $showtime->movie->title }}</h5>
                            <p class="mb-1"><strong>Date:</strong> {{ $showtime->date ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Time:</strong> {{ $showtime->time ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Screen:</strong> {{ $showtime->screen->name }}</p>
                            <p class="mb-1"><strong>Price per ticket:</strong> ${{ number_format($showtime->price, 2) }}</p>
                            <p class="mb-1"><strong>Available seats:</strong> {{ $availableSeats }}</p>
                        </div>
                    </div>

                    <form action="{{ route('bookings.store', $showtime) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="number_of_tickets" class="form-label">Number of Tickets</label>
                            <input type="number" class="form-control @error('number_of_tickets') is-invalid @enderror" 
                                id="number_of_tickets" name="number_of_tickets" 
                                min="1" max="{{ min(10, $availableSeats) }}" 
                                value="{{ old('number_of_tickets', 1) }}" required>
                            @error('number_of_tickets')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Maximum {{ min(10, $availableSeats) }} tickets per booking
                            </small>
                        </div>

                        <div class="mb-4">
                            <h6>Booking Summary</h6>
                            <div id="booking-summary">
                                <p>Total Amount: $<span id="total-amount">{{ number_format($showtime->price, 2) }}</span></p>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" {{ $availableSeats < 1 ? 'disabled' : '' }}>
                                {{ $availableSeats < 1 ? 'No Seats Available' : 'Confirm Booking' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ticketInput = document.getElementById('number_of_tickets');
    const totalAmountSpan = document.getElementById('total-amount');
    const pricePerTicket = {{ $showtime->price }};

    ticketInput.addEventListener('input', function() {
        const numberOfTickets = parseInt(this.value) || 0;
        const totalAmount = numberOfTickets * pricePerTicket;
        totalAmountSpan.textContent = totalAmount.toFixed(2);
    });
});
</script>
@endpush
@endsection 