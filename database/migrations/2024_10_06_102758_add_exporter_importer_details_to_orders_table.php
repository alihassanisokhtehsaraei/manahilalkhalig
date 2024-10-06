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
        Schema::table('orders', function (Blueprint $table) {
            // Exporter details
            $table->string('exporter_contact_person_name')->nullable();
            $table->text('exporter_address')->nullable();
            $table->string('exporter_city_country')->nullable(); // 'city - country'
            $table->string('exporter_phone')->nullable();

            // Importer details
            $table->string('importer_company_name')->nullable();
            $table->string('importer_contact_person_name')->nullable();
            $table->text('importer_address')->nullable();
            $table->string('importer_city_country')->nullable(); // 'city - country'
            $table->string('importer_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the added columns in reverse order
            $table->dropColumn([
                'exporter_contact_person_name',
                'exporter_address',
                'exporter_city_country',
                'exporter_phone',
                'importer_company_name',
                'importer_contact_person_name',
                'importer_address',
                'importer_city_country',
                'importer_phone',
            ]);
        });
    }
};
