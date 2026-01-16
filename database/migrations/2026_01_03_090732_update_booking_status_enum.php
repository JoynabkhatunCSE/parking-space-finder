<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::statement("
            ALTER TABLE bookings 
            MODIFY status ENUM(
                'pending',
                'paid',
                'cancelled',
                'completed',
                'expired'
            ) DEFAULT 'pending'
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE bookings 
            MODIFY status ENUM(
                'pending',
                'cancelled',
                'completed',
                'expired'
            ) DEFAULT 'pending'
        ");
    }
};


