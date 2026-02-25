<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_payable_details', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['accounting_category_id']);

            // Re-add with cascadeOnDelete
            $table->foreign('accounting_category_id')
                  ->references('id')
                  ->on('accounting_categories')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('account_payable_details', function (Blueprint $table) {
            // Drop the cascade FK
            $table->dropForeign(['accounting_category_id']);

            // Restore original restrictive FK
            $table->foreign('accounting_category_id')
                  ->references('id')
                  ->on('accounting_categories')
                  ->restrictOnDelete();
        });
    }
};