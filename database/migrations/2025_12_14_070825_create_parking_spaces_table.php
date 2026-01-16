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
       Schema::create('parking_spaces', function (Blueprint $table) {
    $table->id();
    $table->foreignId('parking_lot_id')->constrained()->cascadeOnDelete();
    $table->string('space_number');
    $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('parking_spaces');
    }
};
