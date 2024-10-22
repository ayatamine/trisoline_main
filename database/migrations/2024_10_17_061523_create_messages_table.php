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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->nullable()->references('id')->on('discussions')->constrained();
            $table->foreignId('sender_id')->nullable()->references('id')->on('users')->constrained();
            $table->foreignId('receiver_id')->nullable()->references('id')->on('users')->constrained();
            $table->text('content');
            $table->mediumText('attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
