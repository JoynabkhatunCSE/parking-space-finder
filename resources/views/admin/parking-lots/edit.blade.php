@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Edit Parking Lot</h1>

    <form method="POST" action="{{ route('admin.parking-lots.update', $parkingLot) }}">
        @csrf
        @method('PUT')

        @include('admin.parking-lots.partials.form', ['parkingLot' => $parkingLot])

        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
            Update
        </button>
    </form>
</div>
@endsection
