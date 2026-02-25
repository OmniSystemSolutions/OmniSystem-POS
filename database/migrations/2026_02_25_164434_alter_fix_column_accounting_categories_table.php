<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add new unified columns
        Schema::table('accounting_categories', function (Blueprint $table) {
            $table->string('category')->nullable()->after('mode');
            $table->string('account_code')->nullable()->after('category');
            $table->string('type')->nullable()->after('account_code');
        });

        // Step 2: Migrate existing data into unified columns
        DB::statement("
            UPDATE accounting_categories
            SET
                category     = COALESCE(category_payable, category_receivable),
                account_code = COALESCE(account_code_payable, account_code_receivable),
                type         = COALESCE(type_payable, type_receivable)
        ");

        // Step 3: Drop old columns
        Schema::table('accounting_categories', function (Blueprint $table) {
            $table->dropColumn([
                'mode',
                'category_payable',
                'category_receivable',
                'account_code_payable',
                'account_code_receivable',
                'type_payable',
                'type_receivable',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('accounting_categories', function (Blueprint $table) {
            $table->string('mode')->nullable()->after('id');
            $table->string('category_payable')->nullable();
            $table->string('account_code_payable')->nullable();
            $table->string('category_receivable')->nullable();
            $table->string('account_code_receivable')->nullable();
            $table->string('type_payable')->nullable();
            $table->string('type_receivable')->nullable();
            $table->dropColumn(['category', 'account_code', 'type']);
        });
    }
};