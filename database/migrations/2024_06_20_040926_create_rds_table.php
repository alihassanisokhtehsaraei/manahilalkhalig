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
        Schema::create('rds', function (Blueprint $table) {
            $table->id();
            $table->text('docNo')->nullable();
            $table->text('issuingDate')->nullable();
            $table->text('entryPort')->nullable();
            $table->text('importer')->nullable();
            $table->text('certNo')->nullable();
            $table->text('certExpDate')->nullable();
            $table->text('items')->nullable();
            $table->text('conPack')->nullable();
            $table->text('imDoc')->nullable();
            $table->text('noLine')->nullable();
            $table->text('shipmentType')->nullable();
            $table->text('shipmentDetails')->nullable();
            $table->text('total')->nullable();
            $table->text('tArrived')->nullable();
            $table->text('arrived')->nullable();
            $table->text('pending')->nullable();
            $table->text('comments')->nullable();
            $table->text('disclaimer')->nullable();
            $table->text('signee')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->date('reviewDate')->nullable();
            $table->text('ip')->nullable();
            $table->unsignedBigInteger('coc_id')->nullable();
            $table->integer('type')->nullable();
            $table->text('reason')->nullable();
            $table->integer('status')->nullable();
            $table->text('extra')->nullable();
            $table->text('lifetime')->nullable();
            $table->text('visibility')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('coc_id')->references('id')->on('cocs')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('cocs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rds');
    }
};
