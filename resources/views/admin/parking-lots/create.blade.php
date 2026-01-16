@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Add Parking Lot</h1>

    <form method="POST" action="{{ route('admin.parking-lots.store') }}">
        @csrf

        @include('admin.parking-lots.partials.form')

        <button class="mt-4 px-4 py-2 bg-green-600 text-red rounded">
            Save
        </button>
    </form>
</div>
@endsection
