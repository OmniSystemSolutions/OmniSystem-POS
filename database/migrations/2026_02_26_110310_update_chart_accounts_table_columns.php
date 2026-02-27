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
        Schema::table('chart_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('chart_accounts', 'category_id')) {
            $table->dropColumn('category_id');
        }

        if (Schema::hasColumn('chart_accounts', 'subcategory_id')) {
            $table->dropColumn('subcategory_id');
        }

        if (!Schema::hasColumn('chart_accounts', 'accounting_category_id')) {
            $table->foreignId('accounting_category_id')
                  ->nullable()
                  ->constrained('accounting_categories')
                  ->cascadeOnDelete();
        }

        if (!Schema::hasColumn('chart_accounts', 'accounting_subcategory_id')) {
            $table->foreignId('accounting_subcategory_id')
                  ->nullable()
                  ->constrained('accounting_sub_categories')
                  ->cascadeOnDelete();
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chart_accounts', function (Blueprint $table) {
            // Drop new foreign keys
            $table->dropForeign(['accounting_category_id']);
            $table->dropForeign(['accounting_subcategory_id']);

            // Drop new columns
            $table->dropColumn(['accounting_category_id', 'accounting_subcategory_id']);

            // Restore old columns
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
        });
    }
};
