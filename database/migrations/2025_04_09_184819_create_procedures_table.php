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
        Schema::create('procedures', function (Blueprint $table) {
            $table->id()->primary();
            // $table->index('department_id');
            // $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            // $table->foreignId('department_id')->index()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->integer('duration');
            $table->double('cost');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
