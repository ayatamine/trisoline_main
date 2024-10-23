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
        Schema::table('quotas', function (Blueprint $table) {
            $table->unsignedInteger('containers_count')->nullable();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('containers_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotas', function (Blueprint $table) {
           $table->dropColumn("containers_count");
        });
        Schema::table('orders', function (Blueprint $table) {
           $table->dropColumn("containers_count");
        });
    }
};
