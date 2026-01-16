<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'hourly_rate',
    ];

    public function parkingSpaces()
    {
        return $this->hasMany(ParkingSpace::class);
    }

    // ✅ Dynamic totals
    public function getTotalSpacesAttribute()
    {
        return $this->parkingSpaces()->count();
    }

    public function getAvailableSpacesAttribute()
    {
        return $this->parkingSpaces()
            ->where('status', ParkingSpace::STATUS_AVAILABLE)
            ->count();
    }

    public function getBookedSpacesAttribute()
    {
        return $this->parkingSpaces()
            ->where('status', ParkingSpace::STATUS_BOOKED)
            ->count();
    }

}

