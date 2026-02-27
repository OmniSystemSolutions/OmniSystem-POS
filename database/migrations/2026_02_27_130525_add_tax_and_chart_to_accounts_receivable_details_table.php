<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts_receivable_details', function (Blueprint $table) {

            // Add tax string column (VAT / NON-VAT / ZERO-RATED)
            if (!Schema::hasColumn('accounts_receivable_details', 'tax')) {
                $table->string('tax')->default('NON-VAT')->after('unit_price');
            }

            // Add chart_account_id if missing
            if (!Schema::hasColumn('accounts_receivable_details', 'chart_account_id')) {
                $table->unsignedBigInteger('chart_account_id')
                      ->nullable()
                      ->after('accounts_receivable_id');

                $table->foreign('chart_account_id')
                      ->references('id')
                      ->on('chart_accounts')
                      ->nullOnDelete();
            }

        });
    }

    public function down(): void
    {
        Schema::table('accounts_receivable_details', function (Blueprint $table) {
            if (Schema::hasColumn('accounts_receivable_details', 'tax')) {
                $table->dropColumn('tax');
            }

            if (Schema::hasColumn('accounts_receivable_details', 'chart_account_id')) {
                $table->dropForeign(['chart_account_id']);
                $table->dropColumn('chart_account_id');
            }
        });
    }
};