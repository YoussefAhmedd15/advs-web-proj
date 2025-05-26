<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'showtime.movie', 'showtime.screen', 'seats']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by confirmation code
        if ($request->filled('confirmation_code')) {
            $query->where('confirmation_code', 'like', '%' . $request->confirmation_code . '%');
        }

        $bookings = $query->latest()->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
            'payment_status' => ['required', 'in:pending,paid,refunded'],
        ]);

        try {
            $booking->update($request->only(['status', 'payment_status']));
            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Booking updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to update booking. Please try again.');
        }
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to delete booking. Please try again.');
        }
    }
} 