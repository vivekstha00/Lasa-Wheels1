<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create($vehicleId)
    {
        $vehicle = Vehicle::with(['type', 'fuel', 'transmission'])->findOrFail($vehicleId);
        
        if (!$vehicle->is_available) {
            return redirect()->route('vehicle.show', $vehicle->id)
                            ->with('error', 'Sorry, this vehicle is currently not available for booking.');
        }
        
        return view('user.pages.booking-create', compact('vehicle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:pickup_date',
            'pickup_location' => 'required|string|max:255',
            'terms' => 'required|accepted'
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        
        // Check if vehicle is available for the selected dates
        if (!$vehicle->isAvailableForDates($request->pickup_date, $request->return_date)) {
            return back()->with('error', 'Sorry, this vehicle is not available for the selected dates.');
        }

        // Calculate total days and amount
        $pickupDate = Carbon::parse($request->pickup_date);
        $returnDate = Carbon::parse($request->return_date);
        $totalDays = $pickupDate->diffInDays($returnDate);
        $totalAmount = $totalDays * $vehicle->price_per_day;

        // Create booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $vehicle->id,
            'pickup_date' => $request->pickup_date,
            'return_date' => $request->return_date,
            'pickup_location' => $request->pickup_location,
            'total_days' => $totalDays,
            'price_per_day' => $vehicle->price_per_day,
            'total_amount' => $totalAmount,
            'status' => 'pending'
        ]);

        return redirect()->route('booking.confirmation', $booking->id)
                        ->with('success', 'Booking request submitted successfully!');
    }

    public function confirmation($id)
    {
        $booking = Booking::with(['vehicle', 'user'])->findOrFail($id);
        
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.pages.booking-confirmation', compact('booking'));
    }

    public function myBookings()
    {
        $bookings = Auth::user()->bookings()
                        ->with('vehicle')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('user.pages.my-bookings', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['vehicle', 'user'])->findOrFail($id);
        
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.pages.booking-details', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
