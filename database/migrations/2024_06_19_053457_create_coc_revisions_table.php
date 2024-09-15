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
        Schema::create('coc_revisions', function (Blueprint $table) {
            $table->id();
            $table->text('certNo')->nullable();
            $table->text('revisedCertNo')->nullable();
            $table->text('rev')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->date('issuaingDate')->nullable();
            $table->text('expDate')->nullable();
            $table->text('regNo')->nullable();
            $table->text('refNo')->nullable();
            $table->text('importerName')->nullable();
            $table->text('importerAdd')->nullable();
            $table->text('importerCityCountry')->nullable();
            $table->text('exporterName')->nullable();
            $table->text('exporterAdd')->nullable();
            $table->text('exporterCityCountry')->nullable();
            $table->text('invAmount')->nullable();
            $table->text('invCurrency')->nullable();
            $table->text('invUSD')->nullable();
            $table->text('invNo')->nullable();
            $table->text('invDate')->nullable();
            $table->text('shipmentCountry')->nullable();
            $table->text('blNo')->nullable();
            $table->text('blDate')->nullable();
            $table->text('packingDetails')->nullable();
            $table->text('numTypePacking')->nullable();
            $table->text('containerDetails')->nullable();
            $table->text('sealNo')->nullable();
            $table->text('remark')->nullable();
            $table->text('assessment')->nullable();
            $table->text('comments')->nullable();
            $table->text('signee')->nullable();
            $table->text('issuingPlace')->nullable();
            $table->text('disclaimer')->nullable();
            $table->text('ip')->nullable();
            $table->foreign('user_id')->references('id')->on('cocs')->onDelete('set null');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->date('reviewDate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coc_revisions');
    }
};
