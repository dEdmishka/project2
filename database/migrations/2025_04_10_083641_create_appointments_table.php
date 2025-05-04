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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            // $table->index('patient_id');
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            // $table->index('staff_id');
            // $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained();
            $table->datetime('time');
            $table->enum('status', ['active', 'closed', 'cancelled'])->default('active');
            $table->foreignId('ward_id')->constrained();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
