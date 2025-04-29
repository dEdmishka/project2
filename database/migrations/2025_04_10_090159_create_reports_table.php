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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            // $table->index('generated_by');
            // $table->foreign('generated_by')->references('id')->on('staff')->onDelete('cascade');
            // $table->index('report_type_id');
            // $table->foreign('report_type_id')->references('id')->on('report_types')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained();
            $table->foreignId('report_type_id')->constrained();
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
        Schema::dropIfExists('reports');
    }
};
