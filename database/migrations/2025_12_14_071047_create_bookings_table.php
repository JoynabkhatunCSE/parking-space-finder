<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('parking_space_id')->constrained()->cascadeOnDelete();
    $table->dateTime('start_time');
    $table->dateTime('end_time');
    $table->decimal('total_cost', 8, 2)->nullable();
    $table->enum('status', ['booked', 'cancelled', 'completed', 'expired'])->default('booked');
    $table->timestamps();
});
;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
