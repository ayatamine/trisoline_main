<?php

use App\Models\Client;
use App\Models\Currency;
use App\Models\ShippingAddress;
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

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->nullable();
            $table->foreignIdFor(Client::class);
            $table->enum('status', ["pending","approved","inspected","completed","refunded"])->default("pending");
            $table->enum('payment_status', ["0","1"])->default(value: "0");
            $table->date('expected_delivery_date')->nullable();
            $table->date('real_delivery_date')->nullable();
            $table->foreignIdFor(ShippingAddress::class);
            $table->foreignIdFor(Currency::class);
            $table->json('vendor_info')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
