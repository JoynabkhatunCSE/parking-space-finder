<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkingLot;
use App\Models\ParkingSpace;
use App\Models\Booking;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $parkingLotsCount   = ParkingLot::count();
    $parkingSpacesCount = ParkingSpace::count();

    $availableSpaces = ParkingSpace::where('status', 'available')->count();
    $bookedSpaces    = ParkingSpace::where('status', 'booked')->count();

    $totalBookings = Booking::count();
    $paidBookings  = Booking::where('status', 'paid')->count();

    $monthlyRevenue = Booking::where('status', 'paid')
    ->whereMonth('updated_at', Carbon::now()->month)
    ->sum('total_cost');


    return view('admin.dashboard', compact(
        'parkingLotsCount',
        'parkingSpacesCount',
        'availableSpaces',
        'bookedSpaces',
        'totalBookings',
        'paidBookings',
        'monthlyRevenue'
    ));
}
}

