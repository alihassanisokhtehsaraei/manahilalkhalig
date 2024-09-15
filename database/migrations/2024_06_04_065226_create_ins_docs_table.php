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
        Schema::create('ins_docs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('category')->nullable();
            $table->string('desc')->nullable();
            $table->unsignedBigInteger('userID')->nullable();
            $table->foreign('userID')->on('users')->references('id')->onDelete('set null');
            $table->unsignedBigInteger('orderID')->nullable();
            $table->foreign('orderID')->on('orders')->references('id')->onDelete('set null');
            $table->integer('status')->nullable();
            $table->unsignedBigInteger('reviewerID')->nullable();
            $table->foreign('reviewerID')->on('users')->references('id')->onDelete('set null');
            $table->dateTime('reviewTime')->nullable();
            $table->string('url');
            $table->string('ip')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ins_docs');
    }
};
