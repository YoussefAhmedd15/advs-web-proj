<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center mb-8">
                        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h2 class="mt-4 text-2xl font-bold text-gray-900">Booking Confirmed!</h2>
                        <p class="mt-2 text-gray-600">Your booking has been successfully created.</p>
                    </div>

                    <div class="max-w-2xl mx-auto">
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold mb-4">Booking Details</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Booking Number</p>
                                    <p class="font-medium">{{ $booking->booking_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Status</p>
                                    <p class="font-medium capitalize">{{ $booking->status }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Movie</p>
                                    <p class="font-medium">{{ $booking->showtime->movie->title }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Showtime</p>
                                    <p class="font-medium">{{ $booking->showtime->date ?? 'N/A' }} {{ $booking->showtime->time ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Screen</p>
                                    <p class="font-medium">{{ $booking->showtime->screen->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Total Amount</p>
                                    <p class="font-medium">${{ number_format($booking->total_amount, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold mb-4">Selected Seats</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($booking->seats as $seat)
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                                        {{ chr(64 + $seat->row_number) }}{{ $seat->column_number }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Actions</h3>
                            <div class="flex flex-wrap gap-4 justify-center">
                                <!-- View Booking Button -->
                                <a href="{{ route('booking.show', $booking) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View Details
                                </a>

                                <!-- Print Ticket Button -->
                                <button onclick="window.print()" 
                                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                    Print Ticket
                                </button>

                                <!-- Cancel Booking Button -->
                                @if($booking->status === 'pending')
                                    <form action="{{ route('booking.cancel', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
                                                onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif

                                <!-- Return to Dashboard Button -->
                                <a href="{{ route('dashboard') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Return to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .bg-white, .bg-white * {
                visibility: visible;
            }
            .bg-white {
                position: absolute;
                left: 0;
                top: 0;
            }
            .bg-gray-50:last-child {
                display: none;
            }
        }
    </style>
    @endpush
</x-app-layout> 