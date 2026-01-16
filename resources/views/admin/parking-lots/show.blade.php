@extends('layouts.app')

@section('content')
        <h2 class="text-xl font-semibold">
            {{ $parkingLot->name }} — Spaces
        </h2>

    <div class="p-6">
        @foreach($parkingLot->parkingSpaces as $space)
            <div class="border p-4 mb-3 rounded flex justify-between">
                <div>
                    <strong>Space #{{ $space->space_number }}</strong>
                    <p>Status: {{ ucfirst($space->status) }}</p>
                </div>

                @if($space->status === 'available')
                    <a href="#"
                       class="bg-green-600 text-white px-4 py-2 rounded">
                        Book
                    </a>
                @else
                    <span class="text-red-500 font-bold">
                        Unavailable
                    </span>
                @endif
            </div>
        @endforeach
    </div>
    @endsection

