<!-- @extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white shadow rounded p-6">
    <h2 class="text-xl font-bold mb-4">Confirm Payment</h2>

    <p><strong>Amount:</strong> ৳{{ $booking->total_cost }}</p>

    <form method="POST">
        @csrf

        <label class="block mt-4 mb-2">Payment Method</label>
        <select name="payment_method" class="w-full border rounded p-2">
            <option value="cash">Cash</option>
            <option value="card">Card</option>
            <option value="mobile">Mobile Banking</option>
        </select>

        <button class="mt-6 w-full bg-green-600 text-white py-2 rounded">
            Pay & Confirm Booking
        </button>
    </form>
</div>
@endsection -->
