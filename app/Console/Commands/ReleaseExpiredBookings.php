<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\ParkingSpace;
use Carbon\Carbon;

class ReleaseExpiredBookings extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bookings:release-expired';

    /**
     * The console command description.
     */
    protected $description = 'Release reserved parking spaces if payment not completed in time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiryTime = Carbon::now()->subMinutes(10);

        $expiredBookings = Booking::where('status', 'pending')
            ->where('created_at', '<=', $expiryTime)
            ->get();

        foreach ($expiredBookings as $booking) {
            // Release parking space
            $booking->parkingSpace->update([
                'status' => ParkingSpace::STATUS_AVAILABLE,
            ]);

            // Mark booking expired
            $booking->update([
                'status' => 'expired',
            ]);
        }

        $this->info('Expired bookings released successfully.');
    }
}
