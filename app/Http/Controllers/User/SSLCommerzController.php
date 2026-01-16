<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SSLCommerzController extends Controller
{
    public function pay(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        // Safety check
        if ($booking->status !== 'pending') {
            return redirect()->route('dashboard')
                ->withErrors('Invalid booking status.');
        }

        $tranId = 'TXN_' . $booking->id . '_' . time();

        // Save transaction id
        $booking->update([
            'transaction_id' => $tranId
        ]);

        // 🔥 SSLCommerz INIT API call (SANDBOX FIX)
        $response = Http::withoutVerifying() // ✅ IMPORTANT FIX
            ->asForm()
            ->post(
                config('services.sslcommerz.init_url'),
                [
                    'store_id'       => config('services.sslcommerz.store_id'),
                    'store_passwd'   => config('services.sslcommerz.store_password'),
                    'total_amount'   => $booking->total_cost,
                    'currency'       => 'BDT',
                    'tran_id'        => $tranId,

                    // Callback URLs
                    'success_url'    => route('sslcommerz.success'),
                    'fail_url'       => route('sslcommerz.fail'),
                    'cancel_url'     => route('sslcommerz.cancel'),

                    // Customer info
                    'cus_name'       => Auth::user()->name,
                    'cus_email'      => Auth::user()->email,
                    'cus_phone'      => '01700000000',
                    'cus_add1'       => 'Dhaka',
                    'cus_city'       => 'Dhaka',
                    'cus_country'    => 'Bangladesh',

                    // Metadata
                    'value_a'        => $booking->id, // VERY IMPORTANT
                ]
            );

        $data = $response->json();

        // ❌ SSLCommerz rejected request
        if (!isset($data['GatewayPageURL']) || empty($data['GatewayPageURL'])) {
            return back()->withErrors('SSLCommerz gateway error.');
        }

        // ✅ REAL REDIRECT TO SSLCommerz
        return redirect()->away($data['GatewayPageURL']);
    }

    public function success(Request $request)
    {
        $booking = Booking::where('id', $request->value_a)->firstOrFail();

        $booking->update(['status' => 'paid']);
        $booking->parkingSpace->update(['status' => 'booked']);

        return redirect()->route('dashboard')
            ->with('success', 'Payment successful! Parking space booked.');
    }

    public function fail()
    {
        return redirect()->route('dashboard')
            ->withErrors('Payment failed. Please try again.');
    }

    public function cancel()
    {
        return redirect()->route('dashboard')
            ->withErrors('Payment cancelled.');
    }
}
