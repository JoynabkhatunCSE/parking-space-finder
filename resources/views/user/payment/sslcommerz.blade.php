@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <div class="bg-white shadow rounded p-6">

        <h2 class="text-2xl font-bold mb-4">SSLCommerz Payment</h2>

        <p><strong>Amount:</strong> ৳{{ $booking->total_cost }}</p>
        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>

        <form method="POST" action="{{ route('payment.success') }}">
            @csrf

            {{-- SSLCommerz normally posts back --}}
            <input type="hidden" name="value_a" value="{{ $booking->id }}">

            <button class="w-full bg-indigo-400 text-green-600 py-2 rounded hover:bg-indigo-400">
                Pay Now (Sandbox)
            </button>
        </form>
        
    </div>
</div>
@endsection
