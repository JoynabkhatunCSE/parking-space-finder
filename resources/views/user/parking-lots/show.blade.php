@extends('layouts.app')

@section('content')
<div class="p-8 max-w-7xl mx-auto">
    {{-- Parking Lot Header --}}
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-8 rounded-2xl mb-8 shadow-2xl">
        <h1 class="text-4xl font-bold mb-2">{{ $parkingLot->name }}</h1>
        <p class="text-xl opacity-90">{{ $parkingLot->address }}</p>
        <p class="text-2xl font-bold mt-4">Rate: ৳{{ number_format($parkingLot->hourly_rate, 0) }}/hour</p>
    </div>

    {{-- Spaces Grid --}}
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($parkingLot->parkingSpaces as $space)
        <div class="border rounded-2xl p-6 shadow-lg transition-all hover:shadow-2xl hover:-translate-y-2
            @if($space->status === \App\Models\ParkingSpace::STATUS_AVAILABLE)
                bg-green-50 border-green-200 hover:border-green-400
            @elseif($space->status === \App\Models\ParkingSpace::STATUS_RESERVED)
                bg-yellow-50 border-yellow-200 hover:border-yellow-400
            @elseif($space->status === \App\Models\ParkingSpace::STATUS_BOOKED)
                bg-red-50 border-red-200 hover:border-red-400
            @else
                bg-gray-100 border-gray-300
            @endif
        ">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-gray-800">
                    #{{ $space->space_number }}
                </h3>
                
                <span class="px-3 py-1 rounded-full text-sm font-bold text-white
                    @if($space->status === \App\Models\ParkingSpace::STATUS_AVAILABLE)
                        bg-green-500
                    @elseif($space->status === \App\Models\ParkingSpace::STATUS_RESERVED)
                        bg-yellow-500
                    @elseif($space->status === \App\Models\ParkingSpace::STATUS_BOOKED)
                        bg-red-500
                    @else
                        bg-gray-500
                    @endif
                ">
                    {{ ucfirst($space->status) }}
                </span>
            </div>

            @if($space->status === \App\Models\ParkingSpace::STATUS_RESERVED && $space->activeBooking)
                <div class="bg-yellow-100 border-2 border-yellow-300 rounded-xl p-3 mb-4">
                    <p class="text-yellow-800 font-semibold mb-1">Payment Pending</p>
                    <p class="text-xs text-yellow-700">
                        ⏳ Expires {{ $space->activeBooking->created_at->addMinutes(15)->diffForHumans() }}
                    </p>
                </div>
            @endif

            {{-- BOOK BUTTON --}}
            @if($space->status === \App\Models\ParkingSpace::STATUS_AVAILABLE)
                <a href="{{ route('parking-spaces.book-form', $space) }}"
                   class="block w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-4 px-6 
                          rounded-xl font-bold text-lg text-center shadow-xl 
                          hover:from-indigo-700 hover:to-blue-700 hover:shadow-2xl 
                          transform hover:-translate-y-1 transition-all duration-300">
                    💳 Book & Pay Now
                </a>
            @else
                <div class="text-center py-6">
                    <div class="text-gray-500 italic mb-2">Not Available</div>
                    @if($space->status === \App\Models\ParkingSpace::STATUS_BOOKED)
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                            ✅ Occupied
                        </span>
                    @endif
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
