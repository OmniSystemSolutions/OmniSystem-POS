<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['supplier_id']);
            
            // Then drop columns
            $table->dropColumn(['brand_name', 'supplier_id']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand_name')->nullable()->after('name');
            $table->foreignId('supplier_id')
                  ->nullable()
                  ->constrained('suppliers')
                  ->nullOnDelete()
                  ->after('unit_id');
        });
    }
};