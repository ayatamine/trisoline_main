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
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('inspected_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('refuned_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('approved_at');
            $table->dropColumn('inspected_at');
            $table->dropColumn('completed_at');
            $table->dropColumn('refuned_at');
        });
    }
};
