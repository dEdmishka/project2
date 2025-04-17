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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            // $table->index('author_id');
            // $table->foreign('author_id')->references('id')->on('users')->nullable()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->index()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->boolean('is_published');
            $table->enum('visibility', ['public', 'staff_only'])->default('public');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
