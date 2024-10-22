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
        Schema::create('quotas', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('legal_representative_name');
            $table->string('country');
            $table->string('full_address');
            $table->string('phone_number');
            $table->string('email');
            $table->string('commercial_register_number')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('available_budget')->nullable();
            $table->string('currency')->nullable();
            $table->enum('service_type',['trade','real_estate'])->nullable();
            $table->json('products')->nullable();
            $table->boolean( 'is_customs_clearance_available')->default(false);
            $table->enum('service_type',['trade','real_estate'])->nullable();
            $table->enum('status',['pending','processing','processed','rejected'])->default('pending');
            $table->string('rejection_note')->nullable();
            $table->timestamp('processing_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->foreignId('client_id')->nullable()->references('id')->on('clients')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotas');
    }
};
