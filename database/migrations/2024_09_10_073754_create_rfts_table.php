<?php

use App\Models\Order;
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
        Schema::create('rfts', function (Blueprint $table) {
            $table->id();
            $table->string('requestType')->nullable();
            $table->string('applicationType')->nullable();
            $table->string('rfc')->nullable();
            $table->string('office')->nullable();
            $table->string('lab')->nullable();
            $table->string('applicantName')->nullable();
            $table->string('applicantAddress')->nullable();
            $table->string('applicantContact')->nullable();
            $table->string('applicantEmail')->nullable();
            $table->string('applicantTel')->nullable();
            $table->string('payerName')->nullable();
            $table->string('payerAddress')->nullable();
            $table->string('payerContact')->nullable();
            $table->string('payerEmail')->nullable();
            $table->string('payerTel')->nullable();
            $table->string('cosqcName')->nullable();
            $table->string('insName')->nullable();
            $table->string('customsName')->nullable();
            $table->string('brokerName')->nullable();
            $table->string('inspectionCompany')->nullable();
            $table->string('cocNoOtherCompany')->nullable();
            $table->string('ref')->nullable();
            $table->string('date')->nullable();
            $table->string('note')->nullable();
            $table->foreignIdFor(Order::class)->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('ip')->nullable();
            $table->string('status')->default(1);
            //Financial Data
            $table->string('finNote')->nullable();
            $table->string('transactionNo')->nullable();
            $table->string('labPaymentMethod')->nullable();
            $table->string('labFeePlace')->nullable();
            $table->string('subSum')->nullable();
            $table->string('tax')->nullable();
            $table->string('totalFee')->nullable();
            $table->integer('financialStatus')->nullable();
            $table->string('finAppUser')->nullable();
            $table->string('finAppDate')->nullable();

            $table->softDeletes(); // Adds created_at and updated_at columns

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfts');
    }
};
