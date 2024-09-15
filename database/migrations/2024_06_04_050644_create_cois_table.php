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
        Schema::create('cois', function (Blueprint $table) {
            $table->id();
            $table->text('certNo');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->date('issuingDate')->nullable();
            $table->text('exporter')->nullable();
            $table->text('applicant')->nullable();
            $table->text('consignee')->nullable();
            $table->text('refDoc')->nullable();
            $table->text('notifyParty')->nullable();
            $table->text('loadingPort')->nullable();
            $table->text('dischargePort')->nullable();
            $table->text('invNo')->nullable();
            $table->text('invDate')->nullable();
            $table->text('commodity')->nullable();
            $table->text('insPlace')->nullable();
            $table->text('insDate')->nullable();
            $table->text('insNote')->nullable();
            $table->text('conclusion')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('branch')->nullable();
            $table->text('userBranch')->nullable();
            $table->text('ip')->nullable();
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->date('reviewDate')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cois');
    }
};
