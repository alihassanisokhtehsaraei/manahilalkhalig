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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->text('tracking_no')->nullable();
            $table->text('exporter')->nullable();
            $table->text('desc')->nullable();
            $table->text('service')->nullable();
            $table->text('piNo')->nullable();
            $table->text('country_origin')->nullable();
            $table->text('container')->nullable();
            $table->integer('container_pending')->nullable();
            $table->text('border')->nullable();
            $table->text('shipmentMethod')->nullable();
            $table->text('shipmentType')->nullable();
            $table->text('branch')->nullable();
            $table->text('ip')->nullable();
            $table->text('technicalStatus')->nullable();
            $table->text('financialStatus')->nullable();
            $table->text('invoiceValue')->nullable();
            $table->text('insFee')->nullable();
            $table->text('borderFeeTotal')->nullable();
            $table->text('borderFeeEach')->nullable();
            $table->text('insFeePlace')->nullable();
            $table->text('borderFeePlace')->nullable();
            $table->text('finAppUser')->nullable();
            $table->text('finAppDate')->nullable();
            $table->text('finNote')->nullable();
            $table->integer('reversion')->nullable();
            $table->integer('v1')->nullable();
            $table->integer('v2')->nullable();
            $table->integer('v3')->nullable();
            $table->text('cocPaymentMethod')->nullable();
            $table->text('borderPaymentMethod')->nullable();
            $table->text('transactionNo')->nullable();
            $table->text('category')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
