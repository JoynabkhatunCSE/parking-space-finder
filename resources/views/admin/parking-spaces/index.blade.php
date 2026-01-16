@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6">

    <h2 class="text-xl font-bold mb-4">
        Manage Spaces for: {{ $parkingLot->name }}
    </h2>

    {{-- Create Space --}}
    <form method="POST"
      action="{{ route('admin.parking-spaces.store', $parkingLot->id) }}"
      class="mb-6 bg-white p-4 rounded shadow">
    @csrf

    <div class="flex gap-4 items-end">
        <div>
            <label class="block text-sm font-medium mb-1">
                Space Number
            </label>
            <input type="text"
                   name="space_number"
                   required
                   class="border rounded px-3 py-2 w-40">
        </div>

        <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Add Space
        </button>
    </div>
</form>


    {{-- Existing Spaces --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($parkingLot->parkingSpaces as $space)
            <div class="bg-white p-4 shadow rounded">
                <strong>Space #{{ $space->space_number }}</strong>
                <p>Status: {{ $space->status }}</p>
            </div>
        @empty
            <p>No spaces yet.</p>
        @endforelse
    </div>

</div>
@endsection
