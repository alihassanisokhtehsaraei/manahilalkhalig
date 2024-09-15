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
        Schema::create('global_counters', function (Blueprint $table) {
            $table->id();
            $table->string('trackingID')->nullable();
            $table->string('service')->nullable();
            $table->string('department')->nullable();
            $table->char('part',2)->nullable();
            $table->char('status',2)->default(0);
            $table->dateTime('registrationDate')->nullable();
            $table->string('fileNoPrefix')->nullable();
            $table->string('fileNo')->nullable();
            $table->dateTime('issuanceDate')->nullable();
            $table->string('user')->nullable();
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
        Schema::dropIfExists('global_counters');
    }
};
