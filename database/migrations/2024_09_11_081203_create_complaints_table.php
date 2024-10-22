<?php

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Order::class)->nullable();
            $table->string('reason');
            $table->mediumText('content');
            $table->enum('status', ["open","under_review","resolved","closed"]);
            $table->mediumText('resolution_summary')->nullable();
            $table->foreignId('resolved_by')->nullable()->references('id')->on('users')->constrained();
            $table->timestampTz('resolved_at')->nullable();
            $table->foreignId('payment_id')->nullable()->references('id')->on('payments')->constrained();
            $table->mediumText('documents')->nullable();
            $table->foreignId('assigned_to')->nullable()->references('id')->on('users')->constrained();
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
