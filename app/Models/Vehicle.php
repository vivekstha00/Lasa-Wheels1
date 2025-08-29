<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type_id',
        'model',
        'fuel_id',
        'transmission_id',
        'price_per_day',
        'image',
        'is_available',
        'brand',
        'year',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function fuel()
    {
        return $this->belongsTo(Fuel::class);
    }

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }
    public function isAvailableForDates($pickupDate, $returnDate)
    {
        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($pickupDate, $returnDate) {
                $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
                    ->orWhereBetween('return_date', [$pickupDate, $returnDate])
                    ->orWhere(function($q) use ($pickupDate, $returnDate) {
                        $q->where('pickup_date', '<=', $pickupDate)
                            ->where('return_date', '>=', $returnDate);
                    });
            })
            ->exists();
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
