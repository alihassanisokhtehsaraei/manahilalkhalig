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
        Schema::create('coc_rev_goods', function (Blueprint $table) {
            $table->id();
            $table->text('quantity')->nullable();
            $table->text('value')->nullable();
            $table->text('origin')->nullable();
            $table->text('desc')->nullable();
            $table->text('standard')->nullable();
            $table->text('type')->nullable();
            $table->unsignedBigInteger('coc_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('ip')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('coc_id')->references('id')->on('cocs')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coc_rev_goods');
    }
};
