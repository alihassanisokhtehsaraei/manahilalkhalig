<?php

use App\Models\Coc;
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
        Schema::create('non_release_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Coc::class)->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->text('containers_details_not_mentioned')->nullable();
            $table->text('import_documents_not_mentioned')->nullable();
            $table->text('number_of_items')->nullable();
            $table->text('shipment_type')->nullable();
            $table->text('shipment_details')->nullable();
            $table->text('remaining_quantity')->nullable();
            $table->text('incoming_quantity')->nullable();
            $table->text('total_quantity')->nullable();
            $table->text('status')->nullable();
            $table->text('comments')->nullable();
            $table->string('document_number')->nullable();
            $table->date('issuance_date')->nullable();
            $table->string('issuing_office')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_release_documents');
    }
};
