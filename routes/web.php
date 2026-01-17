<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\ParkingLotController as UserParkingLotController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\SSLCommerzController;
use App\Http\Controllers\User\ParkingSpaceController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    | User Dashboard
    */
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');

    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | User : Parking Lots
    */
    Route::get('/parking-lots', [UserParkingLotController::class, 'index'])
        ->name('parking-lots.index');

    Route::get('/parking-lots/{parkingLot}', [UserParkingLotController::class, 'show'])
        ->name('parking-lots.show');

    /*
    | User : Parking Spaces - NEW BOOKING FORM
    */
    Route::get('/parking-spaces/{parkingSpace}/book', [ParkingSpaceController::class, 'book'])
        ->name('parking-spaces.book-form');

    /*
    | User : Book Parking Space (POST)
    */
    Route::post('/parking-spaces/{parkingSpace}/book', [BookingController::class, 'store'])
        ->name('parking-spaces.book');

    /*
    |--------------------------------------------------------------------------
    | SSLCommerz Payment Routes (KEEPING YOUR EXISTING + NEW)
    |--------------------------------------------------------------------------
    */
    
    // ✅ KEEP YOUR EXISTING ROUTE (for backward compatibility)
    Route::get('/payment/sslcommerz/{booking}', [SSLCommerzController::class, 'pay'])
        ->name('payment.sslcommerz');

    // ✅ NEW SSLCommerz routes (standard structure)
    Route::prefix('sslcommerz')->name('sslcommerz.')->group(function () {
        Route::get('pay/{booking}', [SSLCommerzController::class, 'pay'])->name('pay');
        Route::any('success', [SSLCommerzController::class, 'success'])->name('success');
        Route::any('fail', [SSLCommerzController::class, 'fail'])->name('fail');
        Route::any('cancel', [SSLCommerzController::class, 'cancel'])->name('cancel');
        Route::post('ipn', [SSLCommerzController::class, 'ipn'])->name('ipn');
    });

    // ✅ SSLCommerz callbacks (KEEPING YOUR EXISTING)
    Route::post('payment/sslcommerz/success', [SSLCommerzController::class, 'success'])->name('payment.sslcommerz.success');
    Route::post('payment/sslcommerz/fail', [SSLCommerzController::class, 'fail'])->name('payment.sslcommerz.fail');
    Route::post('payment/sslcommerz/cancel', [SSLCommerzController::class, 'cancel'])->name('payment.sslcommerz.cancel');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        | Admin Dashboard
        */
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        | Admin : Parking Lots
        */
        Route::resource(
            'parking-lots',
            \App\Http\Controllers\Admin\ParkingLotController::class
        )->except(['show']);

        /*
        | Admin : Parking Spaces
        */
        Route::get('parking-lots/{parkingLot}/spaces',
            [\App\Http\Controllers\Admin\ParkingSpaceController::class, 'index']
        )->name('parking-spaces.index');

        Route::post('parking-lots/{parkingLot}/spaces',
            [\App\Http\Controllers\Admin\ParkingSpaceController::class, 'store']
        )->name('parking-spaces.store');

        Route::put('parking-spaces/{parkingSpace}',
            [\App\Http\Controllers\Admin\ParkingSpaceController::class, 'update']
        )->name('parking-spaces.update');

        Route::delete('parking-spaces/{parkingSpace}',
            [\App\Http\Controllers\Admin\ParkingSpaceController::class, 'destroy']
        )->name('parking-spaces.destroy');
    });

require __DIR__.'/auth.php';
