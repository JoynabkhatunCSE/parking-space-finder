@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-lg p-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Book Space #{{ $parkingSpace->space_number }}</h2>
    
    <div class="bg-blue-50 p-4 rounded mb-6">
        <p><strong>Parking Lot:</strong> {{ $parkingSpace->parkingLot->name }}</p>
        <p><strong>Space:</strong> #{{ $parkingSpace->space_number }}</p>
        <p><strong>Rate:</strong> ৳{{ $parkingSpace->parkingLot->hourly_rate }}/hour</p>
    </div>

{{-- ✅ CORRECT --}}
<form method="POST" action="{{ route('parking-spaces.book', $parkingSpace) }}">
        @csrf
        
        <div>
            <label class="block text-sm font-medium mb-2">Start Time</label>
            <input type="datetime-local" name="start_time" 
                   required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
                   value="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                   min="{{ now()->addMinute()->format('Y-m-d\TH:i') }}">
            @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">End Time</label>
            <input type="datetime-local" name="end_time" 
                   required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
                   min="{{ now()->addHour()->format('Y-m-d\TH:i') }}">
            @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="bg-green-50 p-4 rounded-lg">
            <p class="font-bold text-lg text-green-800" id="total-cost">৳0</p>
            <p class="text-sm text-green-700">Cost updates automatically</p>
        </div>

        <button type="submit" 
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Reserve & Pay Now → 
        </button>
    </form>
</div>

<script>
document.querySelectorAll('input[name="start_time"], input[name="end_time"]').forEach(input => {
    input.addEventListener('change', calculateCost);
});

function calculateCost() {
    const start = document.querySelector('input[name="start_time"]').value;
    const end = document.querySelector('input[name="end_time"]').value;
    const rate = {{ $parkingSpace->parkingLot->hourly_rate ?? 100 }};
    
    if (start && end) {
        const hours = Math.ceil((new Date(end) - new Date(start)) / (1000 * 60 * 60));
        const cost = hours * rate;
        document.getElementById('total-cost').textContent = `৳${cost}`;
    }
}
</script>
@endsection
