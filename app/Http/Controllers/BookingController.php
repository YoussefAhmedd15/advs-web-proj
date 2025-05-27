<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    private $movies;

    public function __construct()
    {
        // Static movie data
        $this->movies = [
            [
                'id' => 1,
                'title' => 'The Dark Knight',
                'genre' => 'Action',
                'duration' => 152,
                'poster' => 'https://example.com/dark-knight.jpg',
                'showtimes' => [
                    [
                        'id' => 1,
                        'time' => '19:00',
                        'hall' => 'Hall A',
                        'occupied_seats' => ['A1', 'A2', 'B3', 'C4']
                    ]
                ]
            ]
        ];
    }

    public function create(Showtime $showtime)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to make a booking.');
        }

        // Check if showtime exists and is in the future
        if (
            !$showtime ||
            ($showtime && $showtime->date->toDateString() < now()->toDateString()) ||
            ($showtime && $showtime->date->toDateString() == now()->toDateString() && $showtime->time < now()->format('H:i:s'))
        ) {
            return back()->with('error', 'This showtime is no longer available.');
        }

        // Load the movie and screen relationships
        $showtime->load(['movie', 'screen']);

        // Check if movie exists and is active
        if (!$showtime->movie || !$showtime->movie->is_active) {
            return back()->with('error', 'This movie is no longer available.');
        }

        // Check if screen exists and is active
        if (!$showtime->screen || !$showtime->screen->is_active) {
            return back()->with('error', 'This screen is no longer available.');
        }

        // Calculate available seats
        $totalBooked = Booking::where('showtime_id', $showtime->id)
            ->where('status', '!=', 'cancelled')
            ->sum('number_of_tickets');
        
        $availableSeats = $showtime->screen->capacity - $totalBooked;

        return view('bookings.create', compact('showtime', 'availableSeats'));
    }

    public function store(Request $request, Showtime $showtime)
    {
        if (!$showtime) {
            abort(404, 'Showtime not found.');
        }

        // Validate the request
        $request->validate([
            'number_of_tickets' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to make a booking.');
        }

        // Check if showtime exists and is in the future
        if (
            !$showtime ||
            ($showtime && $showtime->date->toDateString() < now()->toDateString()) ||
            ($showtime && $showtime->date->toDateString() == now()->toDateString() && $showtime->time < now()->format('H:i:s'))
        ) {
            return back()->with('error', 'This showtime is no longer available.');
        }

        try {
            DB::beginTransaction();

            // Check if there are enough seats available
            $totalBooked = Booking::where('showtime_id', $showtime->id)
                ->where('status', '!=', 'cancelled')
                ->sum('number_of_tickets');
            
            $availableSeats = $showtime->screen->capacity - $totalBooked;
            
            if ($request->number_of_tickets > $availableSeats) {
                return back()->with('error', 'Not enough seats available. Only ' . $availableSeats . ' seats left.');
            }

            // Create the booking
            $booking = new Booking();
            $booking->user_id = Auth::id();
            $booking->showtime_id = $showtime->id;
            $booking->number_of_tickets = $request->number_of_tickets;
            $booking->status = 'pending';
            $booking->amount = $showtime->price * $request->number_of_tickets;
            $booking->payment_status = 'unpaid';
            $booking->save();

            // Log the successful booking creation
            Log::info('Booking created successfully', [
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
                'showtime_id' => $showtime->id,
                'number_of_tickets' => $request->number_of_tickets,
                'amount' => $booking->amount
            ]);

            DB::commit();

            // Redirect to booking details page with success message
            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'showtime_id' => $showtime->id,
                'request_data' => $request->all()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create booking. Please try again.']);
        }
    }

    public function show(Booking $booking)
    {
        // Ensure user can only view their own bookings unless admin
        if (!$booking->user_id === Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    public function showMovieSelection()
    {
        $movies = Movie::with('showtimes')->get();
        return view('bookings.movies', compact('movies'));
    }

    public function showShowtimeSelection(Movie $movie, Showtime $showtime)
    {
        return view('bookings.showtimes', compact('movie', 'showtime'));
    }

    public function showSeatSelection(Showtime $showtime)
    {
        $bookedSeats = $showtime->bookings()->pluck('seat_number')->toArray();
        return view('bookings.seats', compact('showtime', 'bookedSeats'));
    }

    public function showConfirmation(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        return view('bookings.confirmation', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        $booking->delete();
        return redirect()->route('dashboard')->with('success', 'Booking cancelled successfully.');
    }

    public function cancel(Booking $booking)
    {
        // Ensure user can only cancel their own bookings unless admin
        if ($booking->user_id !== Auth::id() && !Auth::user()->is_admin) {
            return back()->with('error', 'You are not authorized to cancel this booking.');
        }

        // Only allow cancellation of confirmed bookings
        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        // Check if showtime is in the future
        if ($booking->showtime->date < now()->format('Y-m-d')) {
            return back()->with('error', 'Cannot cancel bookings for past showtimes.');
        }

        try {
            DB::beginTransaction();
            
            // Delete the booking
            $booking->delete();

            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Booking cancelled and removed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to cancel booking. Please try again.');
        }
    }

    public function payment(Request $request, Booking $booking)
    {
        // Ensure user can only pay for their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow payment for pending bookings
        if ($booking->status !== 'pending') {
            return back()->with('error', 'This booking cannot be paid for.');
        }

        $request->validate([
            'card_number' => ['required', 'string', 'regex:/^[\d\s]{19}$/'],
            'expiry' => ['required', 'string', 'regex:/^\d{2}\/\d{2}$/'],
            'cvv' => ['required', 'string', 'regex:/^\d{3}$/'],
        ]);

        try {
            // Here you would typically integrate with a payment gateway
            // For demo purposes, we'll just simulate a successful payment
            $booking->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_method' => 'credit_card',
                'transaction_id' => 'DEMO-' . strtoupper(uniqid()),
            ]);

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Payment successful! Your booking is now confirmed.');
        } catch (\Exception $e) {
            Log::error('Error processing payment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to process payment. Please try again.');
        }
    }
} 