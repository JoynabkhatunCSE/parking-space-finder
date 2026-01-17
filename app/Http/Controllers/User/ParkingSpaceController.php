<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ParkingSpace;

class ParkingSpaceController extends Controller
{
    public function book(ParkingSpace $parkingSpace)
    {
        return view('user.parking-spaces.book', compact('parkingSpace'));
    }
}
