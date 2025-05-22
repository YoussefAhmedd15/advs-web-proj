@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Movie and Showtime Info -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center space-x-4">
                <img src="{{ $showtime->movie->poster_url }}" alt="{{ $showtime->movie->title }}" class="w-24 h-36 object-cover rounded-lg shadow">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $showtime->movie->title }}</h1>
                    <p class="text-gray-600">{{ $showtime->movie->genre }} • {{ $showtime->movie->duration_minutes }} min</p>
                    <p class="text-gray-600">{{ $showtime->start_time->format('l, F j, Y') }} at {{ $showtime->start_time->format('g:i A') }}</p>
                    <p class="text-gray-600">Screen: {{ $showtime->screen->name }}</p>
                </div>
            </div>
        </div>

        <!-- Seat Selection -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Select Your Seats</h2>
            
            <!-- Screen Display -->
            <div class="mb-8">
                <div class="w-full h-4 bg-gray-200 rounded-t-lg mb-2"></div>
                <div class="text-center text-gray-600 mb-8">SCREEN</div>
            </div>

            <!-- Seat Legend -->
            <div class="flex justify-center space-x-8 mb-8">
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-gray-200 rounded mr-2"></div>
                    <span class="text-sm text-gray-600">Available</span>
                </div>
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-blue-500 rounded mr-2"></div>
                    <span class="text-sm text-gray-600">Selected</span>
                </div>
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-red-500 rounded mr-2"></div>
                    <span class="text-sm text-gray-600">Booked</span>
                </div>
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-purple-500 rounded mr-2"></div>
                    <span class="text-sm text-gray-600">VIP</span>
                </div>
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-pink-500 rounded mr-2"></div>
                    <span class="text-sm text-gray-600">Couple</span>
                </div>
            </div>

            <!-- Seats Grid -->
            <div class="flex justify-center mb-8">
                <div class="grid grid-cols-10 gap-2">
                    @foreach($seats as $seat)
                        <button 
                            class="seat-button w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium transition-colors duration-200
                                {{ $seat->is_booked ? 'bg-red-500 cursor-not-allowed' : 
                                   ($seat->type === 'vip' ? 'bg-purple-500 hover:bg-purple-600' : 
                                    ($seat->type === 'couple' ? 'bg-pink-500 hover:bg-pink-600' : 
                                    'bg-gray-200 hover:bg-gray-300')) }}
                                {{ in_array($seat->id, $selectedSeats) ? 'bg-blue-500 hover:bg-blue-600' : '' }}"
                            data-seat-id="{{ $seat->id }}"
                            data-seat-number="{{ $seat->seat_number }}"
                            data-seat-type="{{ $seat->type }}"
                            data-price="{{ $seat->price }}"
                            {{ $seat->is_booked ? 'disabled' : '' }}
                        >
                            {{ $seat->seat_number }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Selected Seats Summary -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Selected Seats</h3>
                <div id="selected-seats" class="space-y-2">
                    <!-- Selected seats will be displayed here -->
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Amount:</span>
                        <span id="total-amount" class="text-xl font-bold text-gray-900">$0.00</span>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <form action="{{ route('bookings.store', $showtime) }}" method="POST" id="booking-form">
                @csrf
                <input type="hidden" name="seat_ids[]" id="selected-seats-input">
                <input type="hidden" name="total_amount" id="total-amount-input">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="customer_name" id="customer_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="customer_email" id="customer_email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="customer_phone" id="customer_phone" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests (Optional)</label>
                        <input type="text" name="special_requests" id="special_requests"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('bookings.showtimes', $showtime->movie_id) }}" 
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        Back
                    </a>
                    <button type="submit" id="proceed-button" disabled
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectedSeats = new Set();
    const selectedSeatsDiv = document.getElementById('selected-seats');
    const totalAmountSpan = document.getElementById('total-amount');
    const selectedSeatsInput = document.getElementById('selected-seats-input');
    const totalAmountInput = document.getElementById('total-amount-input');
    const proceedButton = document.getElementById('proceed-button');
    let totalAmount = 0;

    // Seat selection handling
    document.querySelectorAll('.seat-button').forEach(button => {
        button.addEventListener('click', function() {
            const seatId = this.dataset.seatId;
            const seatNumber = this.dataset.seatNumber;
            const seatType = this.dataset.seatType;
            const price = parseFloat(this.dataset.price);

            if (selectedSeats.has(seatId)) {
                // Deselect seat
                selectedSeats.delete(seatId);
                this.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                this.classList.add(
                    seatType === 'vip' ? 'bg-purple-500 hover:bg-purple-600' :
                    seatType === 'couple' ? 'bg-pink-500 hover:bg-pink-600' :
                    'bg-gray-200 hover:bg-gray-300'
                );
                totalAmount -= price;
            } else {
                // Select seat
                selectedSeats.add(seatId);
                this.classList.remove(
                    seatType === 'vip' ? 'bg-purple-500 hover:bg-purple-600' :
                    seatType === 'couple' ? 'bg-pink-500 hover:bg-pink-600' :
                    'bg-gray-200 hover:bg-gray-300'
                );
                this.classList.add('bg-blue-500', 'hover:bg-blue-600');
                totalAmount += price;
            }

            updateSelectedSeatsDisplay();
            updateFormState();
        });
    });

    function updateSelectedSeatsDisplay() {
        selectedSeatsDiv.innerHTML = '';
        selectedSeats.forEach(seatId => {
            const button = document.querySelector(`[data-seat-id="${seatId}"]`);
            const seatNumber = button.dataset.seatNumber;
            const seatType = button.dataset.seatType;
            const price = parseFloat(button.dataset.price);

            const seatDiv = document.createElement('div');
            seatDiv.className = 'flex justify-between items-center text-sm';
            seatDiv.innerHTML = `
                <span class="text-gray-600">${seatNumber} (${seatType.toUpperCase()})</span>
                <span class="text-gray-900">$${price.toFixed(2)}</span>
            `;
            selectedSeatsDiv.appendChild(seatDiv);
        });

        totalAmountSpan.textContent = `$${totalAmount.toFixed(2)}`;
    }

    function updateFormState() {
        // Update hidden input with selected seat IDs
        const selectedSeatsArray = Array.from(selectedSeats);
        selectedSeatsInput.value = selectedSeatsArray.join(',');
        
        // Create hidden inputs for each selected seat
        const existingInputs = document.querySelectorAll('input[name="seat_ids[]"]');
        existingInputs.forEach(input => {
            if (input.id !== 'selected-seats-input') {
                input.remove();
            }
        });
        
        selectedSeatsArray.forEach(seatId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'seat_ids[]';
            input.value = seatId;
            document.getElementById('booking-form').appendChild(input);
        });

        totalAmountInput.value = totalAmount.toFixed(2);
        proceedButton.disabled = selectedSeats.size === 0;
    }
});
</script>
@endpush

@push('styles')
<style>
.seat-button {
    transition: all 0.2s ease-in-out;
}

.seat-button:disabled {
    cursor: not-allowed;
    opacity: 0.7;
}

.seat-button:not(:disabled):hover {
    transform: scale(1.1);
}
</style>
@endpush
@endsection 