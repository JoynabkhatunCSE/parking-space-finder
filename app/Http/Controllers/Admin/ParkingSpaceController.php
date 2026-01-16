<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingLot;
use App\Models\ParkingSpace;
use Illuminate\Http\Request;

class ParkingSpaceController extends Controller
{
    /**
     * Show spaces of a parking lot
     */
    public function index(ParkingLot $parkingLot)
    {
        $spaces = $parkingLot->parkingSpaces()
            ->orderBy('space_number')
            ->get();

        return view('admin.parking-spaces.index', compact('parkingLot', 'spaces'));
    }

    /**
     * Store a new parking space
     */
    public function store(Request $request, ParkingLot $parkingLot)
    {
        $request->validate([
            'space_number' => [
                'required',
                'string',
                'max:20',
                // ✅ Prevent duplicate space numbers per lot
                function ($attribute, $value, $fail) use ($parkingLot) {
                    if ($parkingLot->parkingSpaces()
                        ->where('space_number', $value)
                        ->exists()) {
                        $fail('This space number already exists in this parking lot.');
                    }
                }
            ],
        ]);

        $parkingLot->parkingSpaces()->create([
            'space_number' => $request->space_number,
            'status'       => ParkingSpace::STATUS_AVAILABLE, // ✅ ENUM SAFE
        ]);

        return back()->with('success', 'Parking space added successfully.');
    }

    /**
     * Update parking space
     */
    public function update(Request $request, ParkingSpace $parkingSpace)
    {
        $validated = $request->validate([
            'space_number' => 'required|string|max:50',
            'status' => 'required|in:' . implode(',', [
                ParkingSpace::STATUS_AVAILABLE,
                ParkingSpace::STATUS_RESERVED,
                ParkingSpace::STATUS_BOOKED,
                ParkingSpace::STATUS_MAINTENANCE,
            ]),
        ]);

        $parkingSpace->update($validated);

        return back()->with('success', 'Parking space updated.');
    }

    /**
     * Delete parking space
     */
    public function destroy(ParkingSpace $parkingSpace)
    {
        $parkingSpace->delete();

        return back()->with('success', 'Parking space deleted.');
    }
}
