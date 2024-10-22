<?php

use App\Models\Client;
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

        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class);
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('phone_number', 255);
            $table->string('country', 255);
            $table->string('city', 255);
            $table->unsignedInteger('zip_code');
            $table->string(column: 'full_address')->virtualAs('concat(first_name, \' \', last_name, \' \', phone_number, \' \', country, \' \', zip_code)');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_addresses');
    }
};
