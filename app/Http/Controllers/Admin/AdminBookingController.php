<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    // View all bookings
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'vehicle', 'vehicle.type', 'vehicle.fuel', 'vehicle.transmission']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Search by customer name or booking ID
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    // View single booking details
    public function show($id)
    {
        $booking = Booking::with(['user', 'vehicle', 'vehicle.type', 'vehicle.fuel', 'vehicle.transmission'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    // Approve booking (pending → confirmed)
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be approved.');
        }
        
        $booking->update(['status' => 'confirmed']);
        
        return back()->with('success', 'Booking approved successfully!');
    }

    // Reject booking (pending → cancelled)
    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be rejected.');
        }
        
        $booking->update(['status' => 'cancelled']);
        
        return back()->with('success', 'Booking rejected successfully.');
    }

    // Mark as active (confirmed → active) - Vehicle picked up
    public function markActive($id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can be marked as active.');
        }
        
        $booking->update(['status' => 'active']);
        
        return back()->with('success', 'Vehicle marked as picked up!');
    }

    // Mark as completed (active → completed) - Vehicle returned
    public function markCompleted($id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->status !== 'active') {
            return back()->with('error', 'Only active bookings can be completed.');
        }
        
        $booking->update(['status' => 'completed']);
        
        return back()->with('success', 'Booking completed successfully!');
    }

    // Update booking status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,active,completed,cancelled'
        ]);
        
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);
        
        return back()->with('success', 'Booking status updated successfully!');
    }
}
