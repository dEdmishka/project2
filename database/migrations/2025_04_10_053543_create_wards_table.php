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
        Schema::create('wards', function (Blueprint $table) {
            $table->id()->primary();
            // $table->index('department_id');
            // $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreignId('department_id')->index()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('ward_number');
            $table->integer('capacity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
