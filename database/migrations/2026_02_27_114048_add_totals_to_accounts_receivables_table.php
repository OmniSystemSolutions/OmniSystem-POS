<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts_receivables', function (Blueprint $table) {

            if (!Schema::hasColumn('accounts_receivables', 'sub_total')) {
                $table->decimal('sub_total', 15, 2)->default(0)->after('transaction_type');
            }

            if (!Schema::hasColumn('accounts_receivables', 'total_tax')) {
                $table->decimal('total_tax', 15, 2)->default(0)->after('sub_total');
            }

            if (!Schema::hasColumn('accounts_receivables', 'total_amount')) {
                $table->decimal('total_amount', 15, 2)->default(0)->after('total_tax');
            }

        });
    }

    public function down(): void
    {
        Schema::table('accounts_receivables', function (Blueprint $table) {
            $table->dropColumn(['sub_total', 'total_tax', 'total_amount']);
        });
    }
};