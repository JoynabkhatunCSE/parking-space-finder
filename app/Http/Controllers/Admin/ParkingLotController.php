<?php

namespace App\Http\Controllers\Admin;
use App\Models\ParkingLot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParkingLotController extends Controller
{
    public function index()
    {
        $parkingLots = ParkingLot::latest()->get();
        return view('admin.parking-lots.index', compact('parkingLots'));
    }

    public function create()
    {
        return view('admin.parking-lots.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'total_spaces' => 'required|integer|min:1',
            'hourly_rate' => 'nullable|numeric|min:0',
        ]);

        ParkingLot::create($validated);

        return redirect()
            ->route('admin.parking-lots.index')
            ->with('success', 'Parking lot created successfully.');
    }

    public function edit(ParkingLot $parkingLot)
    {
        return view('admin.parking-lots.edit', compact('parkingLot'));
    }

    public function update(Request $request, ParkingLot $parkingLot)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'total_spaces' => 'required|integer|min:1',
            'hourly_rate' => 'nullable|numeric|min:0',
        ]);

        $parkingLot->update($validated);

        return redirect()
            ->route('admin.parking-lots.index')
            ->with('success', 'Parking lot updated successfully.');
    }

    public function destroy(ParkingLot $parkingLot)
    {
        $parkingLot->delete();

        return redirect()
            ->route('admin.parking-lots.index')
            ->with('success', 'Parking lot deleted successfully.');
    }
}


