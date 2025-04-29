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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            // $table->index('appointment_id');
            // $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreignId('appoinment_id')->constrained();
            // $table->index('ward_id');
            // $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
            $table->foreignId('ward_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
