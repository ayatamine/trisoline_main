<?php

use App\Models\Order;
use App\Models\Quota;
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

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->nullable()->constrained();
            $table->foreignIdFor(Quota::class)->nullable()->constrained();
            $table->string('name', 255);
            $table->decimal('expected_price', 16, 2);
            $table->decimal('price', 16, 2);
            $table->mediumText('description')->nullable();
            $table->unsignedInteger('quantity');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
