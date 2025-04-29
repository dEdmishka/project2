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
        Schema::create('records', function (Blueprint $table) {
            $table->id()->primary();
            // $table->index('patient_id');
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            // $table->index('record_type_id');
            // $table->foreign('record_type_id')->references('id')->on('record_types')->onDelete('cascade');
            // $table->foreignId('patient_id')->index()->onDelete('cascade');
            $table->morphs('recordable');
            $table->foreignId('record_type_id')->constrained();
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
