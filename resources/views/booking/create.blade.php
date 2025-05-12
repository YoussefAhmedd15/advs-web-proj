@extends('layouts.app')

@section('title', 'Book Tickets - ' . $movie['title'])

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Movie Info -->
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ $movie['poster'] }}" class="card-img-top" alt="{{ $movie['title'] }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $movie['title'] }}</h5>
                    <p class="card-text">
                        <span class="badge bg-primary">{{ $movie['genre'] }}</span>
                        <span class="text-muted">{{ $movie['duration'] }} min</span>
                    </p>
                    <p class="card-text">
                        <strong>Showtime:</strong> {{ $showtime['time'] }}<br>
                        <strong>Hall:</strong> {{ $showtime['hall'] }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Seat Selection -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Select Seats</h5>
                    
                    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $movie['id'] }}">
                        <input type="hidden" name="showtime_id" value="{{ $showtime['id'] }}">
                        <input type="hidden" name="seats" id="selectedSeats">

                        <!-- Screen -->
                        <div class="text-center mb-4">
                            <div class="screen">SCREEN</div>
                        </div>

                        <!-- Seats Grid -->
                        <div class="seat-grid mb-4">
                            @php
                                $rows = range('A', 'J');
                                $cols = range(1, 10);
                            @endphp

                            @foreach($rows as $row)
                                <div class="seat-row">
                                    @foreach($cols as $col)
                                        @php
                                            $seat = $row . $col;
                                            $isOccupied = in_array($seat, $showtime['occupied_seats']);
                                        @endphp
                                        <button type="button" 
                                                class="seat {{ $isOccupied ? 'occupied' : '' }}"
                                                data-seat="{{ $seat }}"
                                                {{ $isOccupied ? 'disabled' : '' }}>
                                            {{ $seat }}
                                        </button>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <!-- Legend -->
                        <div class="seat-legend mb-4">
                            <div class="d-flex gap-3">
                                <div>
                                    <span class="seat available"></span>
                                    Available
                                </div>
                                <div>
                                    <span class="seat selected"></span>
                                    Selected
                                </div>
                                <div>
                                    <span class="seat occupied"></span>
                                    Occupied
                                </div>
                            </div>
                        </div>

                        <!-- Booking Summary -->
                        <div class="booking-summary mb-4">
                            <h6>Booking Summary</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Selected Seats:</span>
                                <span id="selectedSeatsDisplay">None</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Price per Ticket:</span>
                                <span>${{ number_format($pricePerTicket, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong>Total Amount:</strong>
                                <strong id="totalAmount">$0.00</strong>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="bookButton" disabled>
                            Book Tickets
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const seats = document.querySelectorAll('.seat:not(.occupied)');
    const selectedSeatsInput = document.getElementById('selectedSeats');
    const selectedSeatsDisplay = document.getElementById('selectedSeatsDisplay');
    const totalAmount = document.getElementById('totalAmount');
    const bookButton = document.getElementById('bookButton');
    const pricePerTicket = {{ $pricePerTicket }};
    let selectedSeats = [];

    seats.forEach(seat => {
        seat.addEventListener('click', function() {
            const seatNumber = this.dataset.seat;
            
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedSeats = selectedSeats.filter(seat => seat !== seatNumber);
            } else {
                this.classList.add('selected');
                selectedSeats.push(seatNumber);
            }

            updateBookingSummary();
        });
    });

    function updateBookingSummary() {
        selectedSeatsInput.value = JSON.stringify(selectedSeats);
        selectedSeatsDisplay.textContent = selectedSeats.length ? selectedSeats.join(', ') : 'None';
        totalAmount.textContent = '$' + (selectedSeats.length * pricePerTicket).toFixed(2);
        bookButton.disabled = selectedSeats.length === 0;
    }
});
</script>
@endpush
@endsection 