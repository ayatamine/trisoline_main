<?php

use App\Models\Client;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Client::class)->nullable();
            $table->foreignIdFor(Order::class)->nullable();
            $table->timestampTz('transfered_at');
            $table->timestampTz('arrived_at')->nullable();
            $table->double('amount');
            $table->string('bank_name')->nullable();
            $table->string(column: 'swift_code')->nullable();
            $table->string('account_number')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('beneficiary_address')->nullable();
            $table->enum('status', ["pending","approved","received",'rejected','refunded'])->default('pending');
            $table->mediumText('documents')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->timestampTz('approved_at')->comment('approved by admin at ')->nullable();
            $table->timestampTz('received_at')->comment(comment: 'received by client at ')->nullable();
            $table->enum('bank_account_type', ["USD","CNY"]);
            $table->string('type')->default('direct');
            $table->string('payment_reason')->nullable();
            $table->string('note')->nullable();
            $table->string( 'full_title')->virtualAs('concat(id, \' \', transfered_at, \' \', bank_name, \' \', amount)');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
