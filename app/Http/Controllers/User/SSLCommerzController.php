<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SSLCommerzController extends Controller
{
    public function pay(Booking $booking)
    {
        // Security checks
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if($booking->status !== 'pending', 403);

        $tranId = 'TXN_' . $booking->id . '_' . time();
        
        // Save transaction ID
        $booking->update(['transaction_id' => $tranId]);
        
        Log::info('Payment initiated', ['booking_id' => $booking->id, 'tran_id' => $tranId]);

        // SSLCommerz init
        $response = Http::withoutVerifying()
            ->asForm()
            ->post(config('services.sslcommerz.init_url'), [
                'store_id' => config('services.sslcommerz.store_id'),
                'store_passwd' => config('services.sslcommerz.store_password'),
                'total_amount' => $booking->total_cost,
                'currency' => 'BDT',
                'tran_id' => $tranId,
                'success_url' => route('sslcommerz.success'),
                'fail_url' => route('sslcommerz.fail'),
                'cancel_url' => route('sslcommerz.cancel'),
                'ipn_url' => route('sslcommerz.ipn'),
                'cus_name' => Auth::user()->name,
                'cus_email' => Auth::user()->email,
                'cus_add1' => 'Dhaka',
                'cus_city' => 'Dhaka',
                'cus_country' => 'Bangladesh',
                'value_a' => $booking->id,
            ]);

        $data = $response->json();

        if (!isset($data['GatewayPageURL']) || empty($data['GatewayPageURL'])) {
            Log::error('SSLCommerz init failed', ['response' => $data]);
            return back()->withErrors('Payment gateway error: ' . ($data['failedreason'] ?? 'Unknown'));
        }

        return redirect()->away($data['GatewayPageURL']);
    }

    public function success(Request $request)
    {
        $bookingId = $request->value_a;
        $booking = Booking::findOrFail($bookingId);

        // VALIDATE PAYMENT WITH SSLCOMMERZ
        $validateUrl = config('services.sslcommerz.validate_base_url') . $request->val_id;
        $validation = Http::asForm()->post($validateUrl, [
            'store_id' => config('services.sslcommerz.store_id'),
            'store_passwd' => config('services.sslcommerz.store_password'),
            'val_id' => $request->val_id,
            'tran_id' => $request->tran_id,
        ]);

        $validationData = $validation->json();

        Log::info('SSLCommerz validation', [
            'booking_id' => $bookingId,
            'validation' => $validationData
        ]);

        if ($validationData['status'] === 'VALID' && 
            (float)$validationData['amount'] == $booking->total_cost &&
            $validationData['tran_id'] === $booking->transaction_id) {

            $booking->update(['status' => 'paid']);
            $booking->parkingSpace->update(['status' => 'booked']);

            return redirect()->route('dashboard')
                ->with('success', 'Payment successful! Space booked for ' . $booking->total_cost . ' BDT');
        }

        return redirect()->route('dashboard')->withErrors('Payment verification failed');
    }

    public function fail(Request $request)
    {
        Log::warning('Payment failed', $request->all());
        if ($request->value_a) {
            $booking = Booking::find($request->value_a);
            if ($booking && $booking->status === 'pending') {
                $booking->update(['status' => 'cancelled']);
                $booking->parkingSpace->update(['status' => 'available']);
            }
        }
        return redirect()->route('dashboard')->withErrors('Payment failed');
    }

    public function cancel(Request $request)
    {
        Log::warning('Payment cancelled', $request->all());
        if ($request->value_a) {
            $booking = Booking::find($request->value_a);
            if ($booking && $booking->status === 'pending') {
                $booking->update(['status' => 'cancelled']);
                $booking->parkingSpace->update(['status' => 'available']);
            }
        }
        return redirect()->route('dashboard')->withErrors('Payment cancelled');
    }

    public function ipn(Request $request)
    {
        // Server-to-server validation (silent)
        $bookingId = $request->value_a;
        $booking = Booking::find($bookingId);

        if (!$booking || $booking->status !== 'pending') {
            return response('OK', 200);
        }

        $validateUrl = config('services.sslcommerz.validate_base_url') . $request->val_id;
        $validation = Http::asForm()->post($validateUrl, [
            'store_id' => config('services.sslcommerz.store_id'),
            'store_passwd' => config('services.sslcommerz.store_password'),
            'val_id' => $request->val_id,
            'tran_id' => $request->tran_id,
        ]);

        $validationData = $validation->json();

        if ($validationData['status'] === 'VALID' && 
            (float)$validationData['amount'] == $booking->total_cost) {
            
            $booking->update(['status' => 'paid']);
            $booking->parkingSpace->update(['status' => 'booked']);
        }

        return response('OK', 200);
    }
}
