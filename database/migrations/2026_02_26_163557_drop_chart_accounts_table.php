<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Step 1: Drop wrong FK only if it actually exists ──
        // Check information_schema directly — 100% reliable
        $fkExists = DB::select("
            SELECT COUNT(*) as count
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE CONSTRAINT_SCHEMA = DATABASE()
              AND TABLE_NAME        = 'chart_accounts'
              AND CONSTRAINT_NAME   = 'chart_accounts_accounting_subcategory_id_foreign'
              AND CONSTRAINT_TYPE   = 'FOREIGN KEY'
        ");

        if ($fkExists[0]->count > 0) {
            Schema::table('chart_accounts', function (Blueprint $table) {
                $table->dropForeign(['accounting_subcategory_id']);
            });
        }

        // ── Step 2: NULL out any stale IDs that don't exist in accounting_sub_categories ──
        DB::statement('
            UPDATE chart_accounts
            SET accounting_subcategory_id = NULL
            WHERE accounting_subcategory_id IS NOT NULL
              AND accounting_subcategory_id NOT IN (
                  SELECT id FROM accounting_sub_categories
              )
        ');

        // ── Step 3: Add correct FK → accounting_sub_categories ──
        Schema::table('chart_accounts', function (Blueprint $table) {
            $table->foreign('accounting_subcategory_id')
                  ->references('id')
                  ->on('accounting_sub_categories')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Drop the correct FK
        $fkExists = DB::select("
            SELECT COUNT(*) as count
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE CONSTRAINT_SCHEMA = DATABASE()
              AND TABLE_NAME        = 'chart_accounts'
              AND CONSTRAINT_NAME   = 'chart_accounts_accounting_subcategory_id_foreign'
              AND CONSTRAINT_TYPE   = 'FOREIGN KEY'
        ");

        if ($fkExists[0]->count > 0) {
            Schema::table('chart_accounts', function (Blueprint $table) {
                $table->dropForeign(['accounting_subcategory_id']);
            });
        }

        // Restore old (wrong) FK pointing back to accounting_categories
        Schema::table('chart_accounts', function (Blueprint $table) {
            $table->foreign('accounting_subcategory_id')
                  ->references('id')
                  ->on('accounting_categories')
                  ->nullOnDelete();
        });
    }
};