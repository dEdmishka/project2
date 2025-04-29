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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // $table->index('recipient_id');
            // $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
            // $table->index('sender_id')->nullable();
            // $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreignId('users_id')->index()->onDelete('cascade');
            // $table->foreignId('users_id')->nullable()->index()->onDelete('cascade');
            $table->unsignedBigInteger('recipient_id');
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->foreign('recipient_id')->references('id')->on('users')->constrained();
            $table->foreign('sender_id')->references('id')->on('users')->constrained();

            $table->text('content');
            $table->enum('status', ['pending', 'read'])->default('pending');
            // $table->index('notification_type_id')->nullable();
            // $table->foreignId('notification_type_id')->index()->onDelete('cascade');
            $table->foreignId('notification_type_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
