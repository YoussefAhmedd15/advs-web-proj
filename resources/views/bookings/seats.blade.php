@extends('layouts.app')

@section('title', 'Select Seats - ' . $showtime->movie->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">Select Your Seats</h1>
            
            <!-- Screen -->
            <div class="screen-container mb-4">
                <div class="screen">
                    <div class="screen-text">SCREEN</div>
                </div>
            </div>

            <!-- Seats Grid -->
            <div class="seats-container">
                <div class="row g-2 justify-content-center">
                    @foreach(range('A', 'J') as $row)
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                @foreach(range(1, 10) as $number)
                                    @php
                                        $seatNumber = $row . $number;
                                        $isBooked = in_array($seatNumber, $bookedSeats);
                                    @endphp
                                    <div class="seat-wrapper me-2">
                                        <input type="radio" 
                                               class="btn-check" 
                                               name="seat_number" 
                                               id="seat-{{ $seatNumber }}" 
                                               value="{{ $seatNumber }}"
                                               {{ $isBooked ? 'disabled' : '' }}
                                               autocomplete="off">
                                        <label class="btn btn-outline-primary seat-btn {{ $isBooked ? 'booked' : '' }}" 
                                               for="seat-{{ $seatNumber }}">
                                            {{ $seatNumber }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Legend -->
            <div class="seat-legend mt-4">
                <div class="d-flex justify-content-center gap-4">
                    <div class="d-flex align-items-center">
                        <div class="seat-sample available me-2"></div>
                        <span>Available</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="seat-sample selected me-2"></div>
                        <span>Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="seat-sample booked me-2"></div>
                        <span>Booked</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Booking Summary</h5>
                    <div class="mb-3">
                        <strong>Movie:</strong> {{ $showtime->movie->title }}
                    </div>
                    <div class="mb-3">
                        <strong>Showtime:</strong> {{ $showtime->time }}
                    </div>
                    <div class="mb-3">
                        <strong>Screen:</strong> {{ $showtime->screen->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Selected Seat:</strong>
                        <span id="selected-seat">None</span>
                    </div>
                    <div class="mb-3">
                        <strong>Price:</strong>
                        <span id="seat-price">$0.00</span>
                    </div>

                    <form action="{{ route('bookings.store') }}" method="POST" id="booking-form">
                        @csrf
                        <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                        <input type="hidden" name="seat_number" id="seat-input">
                        
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="book-button" disabled>
                            Book Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .screen-container {
        perspective: 1000px;
    }

    .screen {
        background: #e50914;
        height: 70px;
        margin: 0 auto;
        transform: rotateX(-30deg);
        box-shadow: 0 3px 10px rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .screen-text {
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .seat-wrapper {
        width: 40px;
    }

    .seat-btn {
        width: 100%;
        padding: 0.5rem;
        text-align: center;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .seat-btn.booked {
        background-color: #6c757d;
        border-color: #6c757d;
        cursor: not-allowed;
    }

    .btn-check:checked + .seat-btn {
        background-color: #e50914;
        border-color: #e50914;
    }

    .seat-sample {
        width: 20px;
        height: 20px;
        border-radius: 3px;
    }

    .seat-sample.available {
        background-color: #fff;
        border: 2px solid #e50914;
    }

    .seat-sample.selected {
        background-color: #e50914;
        border: 2px solid #e50914;
    }

    .seat-sample.booked {
        background-color: #6c757d;
        border: 2px solid #6c757d;
    }

    .btn-primary {
        background-color: #e50914;
        border-color: #e50914;
    }

    .btn-primary:hover {
        background-color: #b2070f;
        border-color: #b2070f;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const seatInputs = document.querySelectorAll('input[name="seat_number"]');
    const selectedSeatSpan = document.getElementById('selected-seat');
    const seatPriceSpan = document.getElementById('seat-price');
    const seatInput = document.getElementById('seat-input');
    const bookButton = document.getElementById('book-button');
    const pricePerSeat = 12.00; // Static price, you might want to get this from the backend

    seatInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                const seatNumber = this.value;
                selectedSeatSpan.textContent = seatNumber;
                seatPriceSpan.textContent = `$${pricePerSeat.toFixed(2)}`;
                seatInput.value = seatNumber;
                bookButton.disabled = false;
            }
        });
    });
});
</script>
@endsection 