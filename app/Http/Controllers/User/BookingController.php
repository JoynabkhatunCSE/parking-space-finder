<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ParkingSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request, ParkingSpace $parkingSpace)
{
    // HARD BLOCK if not available
    if ($parkingSpace->status !== ParkingSpace::STATUS_AVAILABLE) {
        return back()->withErrors('This parking space is not available.');
    }

    $request->validate([
        'start_time' => 'required|date|after:now',
        'end_time'   => 'required|date|after:start_time',
    ]);

    // Prevent overlapping booking
    $exists = Booking::where('parking_space_id', $parkingSpace->id)
        ->whereIn('status', ['pending', 'paid'])
        ->where(function ($q) use ($request) {
            $q->whereBetween('start_time', [$request->start_time, $request->end_time])
              ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
        })
        ->exists();

    if ($exists) {
        return back()->withErrors('This parking space is already booked for this time.');
    }

    // Calculate cost
    $hours = ceil(
        (strtotime($request->end_time) - strtotime($request->start_time)) / 3600
    );

    $totalCost = $hours * $parkingSpace->parkingLot->hourly_rate;

    // Create booking
    $booking = Booking::create([
        'user_id'           => Auth::id(),
        'parking_space_id'  => $parkingSpace->id,
        'start_time'        => $request->start_time,
        'end_time'          => $request->end_time,
        'total_cost'        => $totalCost,
        'status'            => 'pending',
    ]);

    // Reserve space
    $parkingSpace->update([
        'status' => ParkingSpace::STATUS_RESERVED,
    ]);

    // 🔥 THIS MUST EXECUTE
    return redirect()->route('payment.sslcommerz', $booking->id);
}
}
