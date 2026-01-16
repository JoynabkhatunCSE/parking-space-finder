<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ParkingSpace extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_lot_id',
        'space_number',
        'status',
    ];

    // ✅ ENUM CONSTANTS (VERY IMPORTANT)
    public const STATUS_AVAILABLE  = 'available';
    public const STATUS_RESERVED   = 'reserved';
    public const STATUS_BOOKED     = 'booked';
    public const STATUS_MAINTENANCE = 'maintenance';
    

    /**
     * Relationships
     */
    public function parkingLot()
    {
        return $this->belongsTo(ParkingLot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function activeBooking()
    {
        return $this->hasOne(Booking::class)
            ->where('status', 'booked')
            ->where('end_time', '>', now());
    } 
}
