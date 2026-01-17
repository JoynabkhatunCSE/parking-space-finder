<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
// Remove or comment out if not using package fully: use Karim007\SslcommerzLaravel\SslCommerz;

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

        // SSLCommerz INIT API call (SANDBOX FIX)
        $response = Http::withoutVerifying() // IMPORTANT for sandbox
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

        // SSLCommerz rejected request
        if (!isset($data['GatewayPageURL']) || empty($data['GatewayPageURL'])) {
            return back()->withErrors('SSLCommerz gateway error: ' . ($data['failedreason'] ?? 'Unknown'));
        }

        // REAL REDIRECT TO SSLCommerz
        return redirect()->away($data['GatewayPageURL']);
    }

    public function success(Request $request)
    {
        $bookingId = $request->value_a;
        $booking = Booking::where('id', $bookingId)->firstOrFail();

        // CRITICAL: VALIDATE payment with SSLCommerz
        $validationResponse = Http::asForm()->post('https://sandbox.sslcommerz.com/verify/' . $request->val_id, [
            'store_id' => config('services.sslcommerz.store_id'),
            'store_passwd' => config('services.sslcommerz.store_password'),
            'val_id' => $request->val_id,
            'tran_id' => $request->tran_id,
        ]);

        $validationData = $validationResponse->json();

        if ($validationData['status'] !== 'VALID' || 
            (float)$validationData['amount'] != $booking->total_cost ||
            $validationData['tran_id'] !== $booking->transaction_id) {
            // Log error, update booking to failed
            $booking->update(['status' => 'failed']);
            return redirect()->route('dashboard')
                ->withErrors('Payment validation failed.');
        }

        // SUCCESS: Update booking and space
        $booking->update(['status' => 'paid']);
        $booking->parkingSpace->update(['status' => 'booked']);

        return redirect()->route('dashboard')
            ->with('success', 'Payment successful! Parking space booked.');
    }

    public function fail()
    {
        // Optional: Find booking by tran_id=value_a and set to failed
        return redirect()->route('dashboard')
            ->withErrors('Payment failed. Please try again.');
    }

    public function cancel()
    {
        // Optional: Find booking by tran_id=value_a and set back to pending/available
        return redirect()->route('dashboard')
            ->withErrors('Payment cancelled.');
    }

    public function ipn(Request $request) // Server-to-server, POST only
    {
        $bookingId = $request->value_a ?? null;
        if (!$bookingId) return response('OK', 200);

        $booking = Booking::find($bookingId);
        if (!$booking) return response('OK', 200);

        // SAME VALIDATION as success (use val_id from request)
        $validationResponse = Http::asForm()->post('https://sandbox.sslcommerz.com/verify/' . $request->val_id, [
            'store_id' => config('services.sslcommerz.store_id'),
            'store_passwd' => config('services.sslcommerz.store_password'),
            'val_id' => $request->val_id,
            'tran_id' => $request->tran_id,
        ]);

        $validationData = $validationResponse->json();

        if ($validationData['status'] === 'VALID' && 
            (float)$validationData['amount'] == $booking->total_cost &&
            $validationData['tran_id'] === $booking->transaction_id &&
            $booking->status === 'pending') {
            
            $booking->update(['status' => 'paid']);
            $booking->parkingSpace->update(['status' => 'booked']);
        }

        return response('OK', 200); // Always respond OK to IPN
    }
}
