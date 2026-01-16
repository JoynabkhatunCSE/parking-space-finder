@foreach($parkingLot->parkingSpaces as $space)

<div class="border rounded-lg p-4 shadow
    @if($space->status === \App\Models\ParkingSpace::STATUS_AVAILABLE)
        bg-green-50
    @elseif($space->status === \App\Models\ParkingSpace::STATUS_RESERVED)
        bg-yellow-50
    @elseif($space->status === \App\Models\ParkingSpace::STATUS_BOOKED)
        bg-red-50
    @else
        bg-gray-100
    @endif
">

    <h3 class="text-lg font-bold mb-1">
        Space #{{ $space->space_number }}
    </h3>

    <p class="mb-3 text-sm">
        Status:
        @if($space->status === \App\Models\ParkingSpace::STATUS_AVAILABLE)
            <span class="text-green-600 font-semibold">Available</span>
        @elseif($space->status === \App\Models\ParkingSpace::STATUS_RESERVED)
            <span class="text-yellow-600 font-semibold">
                Reserved (Payment Pending)
            </span>

            @if($space->status === 'reserved')
    <p class="text-xs text-yellow-600 mt-2">
        Payment pending — reservation expires in 10 minutes
    </p>
@endif

        @elseif($space->status === \App\Models\ParkingSpace::STATUS_BOOKED)
            <span class="text-red-600 font-semibold">Booked</span>
        @else
            <span class="text-gray-600 font-semibold">Maintenance</span>
        @endif
    </p>
    

    {{-- ✅ BOOKING FORM (ONLY IF AVAILABLE) --}}
    @if($space->status === \App\Models\ParkingSpace::STATUS_AVAILABLE)

        <form method="POST"
              action="{{ route('parking-spaces.book', $space) }}">
            @csrf

            <label class="block text-sm mb-1">Start Time</label>
            <input type="datetime-local"
                   name="start_time"
                   class="w-full border rounded p-2 mb-2"
                   required>

            <label class="block text-sm mb-1">End Time</label>
            <input type="datetime-local"
                   name="end_time"
                   class="w-full border rounded p-2 mb-3"
                   required>

            <button
                class="w-full bg-indigo-600 text-white py-2 rounded
                       hover:bg-indigo-700 transition">
                Book Now
            </button>
        </form>

    @else
        <div class="text-center text-sm text-gray-600 italic">
            Not available for booking
        </div>
    @endif

</div>

@endforeach
