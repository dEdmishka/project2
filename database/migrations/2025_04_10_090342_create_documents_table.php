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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // $table->index('patient_id')->nullable();
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            // $table->index('staff_id')->nullable();
            // $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            // $table->index('record_id')->nullable();
            // $table->foreign('record_id')->references('id')->on('records')->onDelete('cascade');
            // $table->foreignId('patient_id')->nullable()->index()->onDelete('cascade');
            // $table->foreignId('staff_id')->nullable()->index()->onDelete('cascade');
            // $table->foreignId('record_id')->nullable()->index()->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('description')->nullable();
            $table->boolean('is_private');
            $table->nullableMorphs('documentable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
