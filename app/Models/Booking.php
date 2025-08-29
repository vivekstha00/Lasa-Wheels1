<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'pickup_date',
        'return_date',
        'pickup_location',
        'total_days',
        'price_per_day',
        'total_amount',
        'status',
        'notes',
        'confirmed_at'
    ];

    protected $dates = [
        'pickup_date',
        'return_date',
        'confirmed_at'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'active' => 'success',
            'completed' => 'secondary',
            'cancelled' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
