@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Parking Lots
        </h1>

        <a href="{{ route('admin.parking-lots.create') }}"
           class="px-4 py-2 bg-indigo-600 text-green-600">
            + Add Parking Lot
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3 border text-center">Name</th>
                    <th class="p-3 border">Address</th>
                    <th class="p-3 border text-center">Spaces</th>
                    <th class="p-3 border text-center">Hourly Rate</th>
                    <th class="p-3 border text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($parkingLots as $lot)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 border font-medium">
                        {{ $lot->name }}
                    </td>

                    <td class="p-3 border">
                        {{ $lot->address }}
                    </td>

                    <td class="p-3 border text-center">
                        
                        <p>Total Spaces: {{ $lot->total_spaces }}</p>

                        <p class="text-green-600 font-semibold">
                            Available: {{ $lot->available_spaces }}
                        </p>

                        <p class="text-red-600 font-semibold">
                            Booked: {{ $lot->booked_spaces }}
                        </p>

                    </td>

                    <td class="p-3 border text-center">
                        ৳{{ $lot->hourly_rate ?? '—' }}
                    </td>

                    <td class="p-3 border text-center space-x-3">

                        {{-- MANAGE SPACES (CRITICAL) --}}
                        <a href="{{ route('admin.parking-spaces.index', $lot->id) }}"
                           class="text-indigo-600 font-semibold hover:underline">
                            Spaces
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('admin.parking-lots.edit', $lot->id) }}"
                           class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.parking-lots.destroy', $lot->id) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Delete this parking lot?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        No parking lots found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
