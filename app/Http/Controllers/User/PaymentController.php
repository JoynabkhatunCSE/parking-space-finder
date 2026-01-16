<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        return view('user.payment.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_cost,
            'payment_method' => $request->payment_method,
            'status' => 'paid',
            'transaction_id' => uniqid('TXN-'),
        ]);

        $booking->update(['status' => 'paid']);
        $booking->parkingSpace->update(['status' => 'booked']);

        return redirect()->route('dashboard')
            ->with('success', 'Payment successful & space booked!');
    }
}