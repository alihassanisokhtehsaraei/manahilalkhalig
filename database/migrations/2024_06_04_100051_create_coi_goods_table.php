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
        Schema::create('coi_goods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->on('orders')->references('id')->onDelete('set null');
            $table->unsignedBigInteger('coi_id')->nullable();
            $table->foreign('coi_id')->on('cois')->references('id')->onDelete('set null');
            $table->text('certType')->nullable();
            $table->text('quantity')->nullable();
            $table->text('packing')->nullable();
            $table->text('desc')->nullable();
            $table->text('netWeight')->nullable();
            $table->text('grossWeight')->nullable();
            $table->text('HSCode')->nullable();
            $table->text('standards')->nullable();
            $table->text('size')->nullable();
            $table->text('user_id');
            $table->text('ip');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coi_goods');
    }
};
