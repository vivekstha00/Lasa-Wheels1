<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Booking;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'address',
        'city',
        'state',
        'postal_code',
        'profile_image',
        'loyalty_points',
        'driver_license',
        'otp',                 
        'otp_expires_at',
        'email_verified_at',
        'role',
        'age',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'loyalty_points' => 'integer',
        ];
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Helper method for profile image URL
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('images/default-avatar.png'); // You can create a default avatar image
    }

    // Calculate total amount spent on completed bookings
    public function getTotalSpentAttribute()
    {
        return $this->bookings()->where('status', 'completed')->sum('total_amount');
    }

    // Count completed bookings
    public function getCompletedBookingsCountAttribute()
    {
        return $this->bookings()->where('status', 'completed')->count();
    }

    // Count pending bookings
    public function getPendingBookingsCountAttribute()
    {
        return $this->bookings()->where('status', 'pending')->count();
    }

    // Count active bookings (currently renting)
    public function getActiveBookingsCountAttribute()
    {
        return $this->bookings()->where('status', 'active')->count();
    }

    // Count confirmed bookings
    public function getConfirmedBookingsCountAttribute()
    {
        return $this->bookings()->where('status', 'confirmed')->count();
    }

    // Count cancelled bookings
    public function getCancelledBookingsCountAttribute()
    {
        return $this->bookings()->where('status', 'cancelled')->count();
    }

    // Get user's membership level based on completed bookings
    public function getMembershipLevelAttribute()
    {
        $completedBookings = $this->completed_bookings_count;
        
        if ($completedBookings >= 10) {
            return 'Gold';
        } elseif ($completedBookings >= 5) {
            return 'Silver';
        } elseif ($completedBookings >= 1) {
            return 'Bronze';
        } else {
            return 'New Member';
        }
    }

    // Get membership level color for badges
    public function getMembershipColorAttribute()
    {
        return match($this->membership_level) {
            'Gold' => 'warning',
            'Silver' => 'secondary', 
            'Bronze' => 'dark',
            default => 'primary'
        };
    }

    // Calculate loyalty points automatically (1 point per रू100 spent)
    public function updateLoyaltyPoints()
    {
        $totalSpent = $this->total_spent;
        $earnedPoints = floor($totalSpent / 100);
        
        if ($this->loyalty_points < $earnedPoints) {
            $this->update(['loyalty_points' => $earnedPoints]);
        }
        
        return $earnedPoints;
    }

    // Get recent bookings (last 5)
    public function getRecentBookingsAttribute()
    {
        return $this->bookings()
                    ->with(['vehicle', 'vehicle.type'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
    }

    // Check if user has active booking
    public function hasActiveBooking()
    {
        return $this->bookings()->where('status', 'active')->exists();
    }

    // Get current active booking
    public function getCurrentBooking()
    {
        return $this->bookings()
                    ->where('status', 'active')
                    ->with(['vehicle'])
                    ->first();
    }

    // Get user's age if date_of_birth is set
    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return $this->date_of_birth->age;
        }
        return null;
    }

    // Format user's full address
    public function getFullAddressAttribute()
    {
        $addressParts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code
        ]);
        
        return implode(', ', $addressParts) ?: 'Address not provided';
    }

    // Check if profile is complete
    public function isProfileComplete()
    {
        $requiredFields = ['phone', 'date_of_birth', 'address', 'city'];
        
        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }
        
        return true;
    }

    // Get profile completion percentage
    public function getProfileCompletionAttribute()
    {
        $fields = ['name', 'email', 'phone', 'date_of_birth', 'address', 'city', 'state', 'postal_code', 'profile_image'];
        $filledFields = 0;
        
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filledFields++;
            }
        }
        
        return round(($filledFields / count($fields)) * 100);
    }
}
