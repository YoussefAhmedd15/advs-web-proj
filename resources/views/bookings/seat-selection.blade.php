<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold">{{ $showtime->movie->title }}</h2>
                        <p class="text-gray-600">
                            {{ $showtime->start_time->format('F j, Y g:i A') }} - 
                            Screen: {{ $showtime->screen->name }}
                        </p>
                    </div>

                    <form action="{{ route('bookings.store', $showtime) }}" method="POST" id="bookingForm">
                        @csrf
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-4">Select Your Seats</h3>
                            
                            <!-- Screen -->
                            <div class="mb-8 text-center">
                                <div class="bg-gray-200 h-8 w-3/4 mx-auto rounded-t-lg"></div>
                                <p class="text-sm text-gray-600 mt-2">Screen</p>
                            </div>

                            <!-- Seat Layout -->
                            <div class="max-w-2xl mx-auto">
                                @foreach($seats as $rowNumber => $rowSeats)
                                    <div class="flex justify-center gap-2 mb-2">
                                        <span class="w-8 text-center font-semibold">{{ chr(64 + $rowNumber) }}</span>
                                        @foreach($rowSeats as $seat)
                                            <button type="button"
                                                    class="seat-button w-10 h-10 rounded-lg flex items-center justify-center text-sm font-medium transition-colors
                                                           {{ $bookedSeatIds->contains($seat->id) 
                                                              ? 'bg-gray-300 cursor-not-allowed' 
                                                              : 'bg-gray-100 hover:bg-blue-100 cursor-pointer' }}"
                                                    data-seat-id="{{ $seat->id }}"
                                                    data-price="{{ $showtime->base_price * $seat->price_multiplier }}"
                                                    {{ $bookedSeatIds->contains($seat->id) ? 'disabled' : '' }}>
                                                {{ $seat->column_number }}
                                            </button>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <!-- Legend -->
                            <div class="mt-8 flex justify-center gap-8">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-gray-100 rounded"></div>
                                    <span>Available</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-blue-500 rounded"></div>
                                    <span>Selected</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-gray-300 rounded"></div>
                                    <span>Booked</span>
                                </div>
                            </div>
                        </div>

                        <!-- Selected Seats Summary -->
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-xl font-semibold mb-4">Selected Seats</h3>
                            <div id="selectedSeats" class="mb-4">
                                <p class="text-gray-600">No seats selected</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-semibold">Total Amount:</span>
                                    <span id="totalAmount" class="text-xl">$0.00</span>
                                </div>
                                <button type="submit" 
                                        class="bg-blue-600 text-white py-2 px-6 rounded hover:bg-blue-700 transition disabled:opacity-50"
                                        id="submitButton"
                                        disabled>
                                    Proceed to Payment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bookingForm');
            const selectedSeats = new Set();
            const selectedSeatsDiv = document.getElementById('selectedSeats');
            const totalAmountSpan = document.getElementById('totalAmount');
            const submitButton = document.getElementById('submitButton');
            let totalAmount = 0;

            // Create hidden input for selected seats
            const seatsInput = document.createElement('input');
            seatsInput.type = 'hidden';
            seatsInput.name = 'seat_ids[]';
            form.appendChild(seatsInput);

            document.querySelectorAll('.seat-button').forEach(button => {
                button.addEventListener('click', function() {
                    const seatId = this.dataset.seatId;
                    const price = parseFloat(this.dataset.price);

                    if (selectedSeats.has(seatId)) {
                        // Deselect seat
                        selectedSeats.delete(seatId);
                        this.classList.remove('bg-blue-500', 'text-white');
                        this.classList.add('bg-gray-100');
                        totalAmount -= price;
                    } else {
                        // Select seat
                        selectedSeats.add(seatId);
                        this.classList.remove('bg-gray-100');
                        this.classList.add('bg-blue-500', 'text-white');
                        totalAmount += price;
                    }

                    // Update UI
                    updateSelectedSeatsDisplay();
                    updateTotalAmount();
                    updateSubmitButton();
                });
            });

            function updateSelectedSeatsDisplay() {
                if (selectedSeats.size === 0) {
                    selectedSeatsDiv.innerHTML = '<p class="text-gray-600">No seats selected</p>';
                    return;
                }

                const seatsList = Array.from(selectedSeats).map(seatId => {
                    const button = document.querySelector(`[data-seat-id="${seatId}"]`);
                    const row = String.fromCharCode(64 + parseInt(button.closest('.flex').querySelector('.font-semibold').textContent));
                    const col = button.textContent;
                    return `${row}${col}`;
                });

                selectedSeatsDiv.innerHTML = `
                    <div class="flex flex-wrap gap-2">
                        ${seatsList.map(seat => `
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                                ${seat}
                            </span>
                        `).join('')}
                    </div>
                `;
            }

            function updateTotalAmount() {
                totalAmountSpan.textContent = `$${totalAmount.toFixed(2)}`;
            }

            function updateSubmitButton() {
                submitButton.disabled = selectedSeats.size === 0;
            }
        });
    </script>
    @endpush
</x-app-layout> 