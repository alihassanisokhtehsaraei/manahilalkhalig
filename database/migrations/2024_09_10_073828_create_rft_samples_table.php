<?php

use App\Models\LabFee;
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
        Schema::create('rft_samples', function (Blueprint $table) {
            $table->id();
            $table->string('desc')->nullable();
            $table->string('quantity')->nullable();
            $table->string('seal')->nullable();
            $table->string('standard')->nullable();
            $table->string('arabic_name')->nullable();
            $table->string('english_name')->nullable();
            $table->string('category')->nullable();
            $table->string('fee')->nullable();
            $table->string('ip')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('rft_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rft_id')->references('id')->on('rfts')->onDelete('set null');

            $table->softDeletes(); // Adds created_at and updated_at columns
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rft_samples');
    }
};
