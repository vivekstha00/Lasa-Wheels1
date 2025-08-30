<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show user profile dashboard
    public function index()
    {
        $user = Auth::user();
        
        // Update loyalty points automatically
        $user->updateLoyaltyPoints();
        
        // Get recent bookings
        $recentBookings = $user->recent_bookings;
        
        // Get booking statistics
        $bookingStats = [
            'total' => $user->bookings()->count(),
            'completed' => $user->completed_bookings_count,
            'pending' => $user->pending_bookings_count,
            'active' => $user->active_bookings_count,
            'confirmed' => $user->confirmed_bookings_count,
            'cancelled' => $user->cancelled_bookings_count,
        ];
        
        return view('user.profile.index', compact('user', 'recentBookings', 'bookingStats'));
    }

    // Show edit profile form
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    // Update profile information
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'driver_license' => 'nullable|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = $request->only([
            'name', 'email', 'phone', 'date_of_birth', 
            'address', 'city', 'state', 'postal_code', 'driver_license'
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $userData['profile_image'] = $imagePath;
        }

        $user->update($userData);

        return redirect()->route('user.profile.index')->with('success', 'Profile updated successfully!');
    }

    // Show change password form
    public function changePasswordForm()
    {
        return view('user.profile.change-password');
    }

    // Update password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('user.profile.index')->with('success', 'Password changed successfully!');
    }

    // Show booking history
    public function bookingHistory(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->bookings()->with(['vehicle', 'vehicle.type']);
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('pickup_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('pickup_date', '<=', $request->date_to);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('user.profile.booking-history', compact('bookings'));
    }

    // Show loyalty points
    public function loyaltyPoints()
    {
        $user = Auth::user();
        
        // Update loyalty points
        $earnedPoints = $user->updateLoyaltyPoints();
        
        // Get point earning history from completed bookings
        $pointsHistory = $user->bookings()
                             ->where('status', 'completed')
                             ->orderBy('updated_at', 'desc')
                             ->get()
                             ->map(function($booking) {
                                 return [
                                     'date' => $booking->updated_at,
                                     'description' => "Booking #{$booking->id} - {$booking->vehicle->name}",
                                     'points' => floor($booking->total_amount / 100),
                                     'amount' => $booking->total_amount
                                 ];
                             });
        
        $totalSpent = $user->total_spent;
        
        return view('user.profile.loyalty-points', compact('user', 'pointsHistory', 'totalSpent'));
    }
}