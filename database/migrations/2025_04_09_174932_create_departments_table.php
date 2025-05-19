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
        Schema::create('departments', function (Blueprint $table) {
            $table->id()->primary();
            // $table->index('center_id');
            // $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            // $table->index('department_type_id');
            // $table->foreign('department_type_id')->references('id')->on('department_types')->onDelete('cascade');
            $table->foreignId('center_id')->constrained();
            $table->foreignId('department_type_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->integer('floor');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
