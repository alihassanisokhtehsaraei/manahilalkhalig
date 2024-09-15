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
        Schema::create('ncrs', function (Blueprint $table) {
            $table->id();
            $table->text('certNo')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->date('issuingDate')->nullable();
            $table->text('regNo')->nullable();
            $table->text('rfi')->nullable();
            $table->text('importer')->nullable();
            $table->text('importerAdd')->nullable();
            $table->text('importerCityCountry')->nullable();
            $table->text('exporter')->nullable();
            $table->text('exporterAdd')->nullable();
            $table->text('exporterCityCountry')->nullable();
            $table->text('invAmount')->nullable();
            $table->text('invCurrency')->nullable();
            $table->text('invNo')->nullable();
            $table->text('invDate')->nullable();
            $table->text('remarks')->nullable();
            $table->text('signee')->nullable();
            $table->text('issuingPlace')->nullable();
            $table->text('disclaimer')->nullable();
            $table->text('ip')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('ncrs');
    }
};
