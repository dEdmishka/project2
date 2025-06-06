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
        Schema::create('staff', function (Blueprint $table) {
            $table->id()->primary();
            // $table->index('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->index('center_id');
            // $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('center_id')->constrained();
            $table->string('birth_date')->nullable() ;
            $table->enum('gender', ['F', 'M'])->default('M');
            $table->string('address')->nullable();
            $table->enum('status', ['active', 'discharge'])->default('active');
            // $table->index('staff_type_id');
            // $table->foreign('staff_type_id')->references('id')->on('staff_types')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->foreignId('staff_type_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
