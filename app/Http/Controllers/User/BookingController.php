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
    // VALIDATION (FIXED)
    $request->validate([
        'start_time' => 'required|date|after_or_equal:' . now()->format('Y-m-d H:i:s'),
        'end_time' => 'required|date|after:start_time'
    ]);

    // Check space availability
    $totalCost = $this->calculateCost($request->start_time, $request->end_time, $parkingSpace->parkingLot->hourly_rate);

    // Create booking
    $booking = Booking::create([
        'user_id' => auth()->id(),
        'parking_space_id' => $parkingSpace->id,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'total_cost' => $totalCost,
        'status' => 'pending'
    ]);

    // Mark space as reserved
    $parkingSpace->update(['status' => ParkingSpace::STATUS_RESERVED]);

    // ✅ IMMEDIATE PAYMENT REDIRECT
    return redirect()->route('payment.sslcommerz', $booking->id)
        ->with('success', 'Booking created! Redirecting to payment...');
}
private function calculateCost($startTime, $endTime, $hourlyRate)
{
    $start = \Carbon\Carbon::parse($startTime);
    $end = \Carbon\Carbon::parse($endTime);
    $hours = $start->diffInHours($end);
    return $hours * $hourlyRate;
}


}
