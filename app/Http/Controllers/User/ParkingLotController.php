<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ParkingLot;

class ParkingLotController extends Controller
{
    public function index()
    {
        $parkingLots = ParkingLot::all();

        return view('user.parking-lots.index', compact('parkingLots'));
    }

   public function show(ParkingLot $parkingLot)
{
    $parkingLot->load([
        'parkingSpaces' => function ($query) {
            $query->with(['activeBooking']); // Load bookings too
        }
    ]);

    return view('user.parking-lots.show', compact('parkingLot'));
}


    
}