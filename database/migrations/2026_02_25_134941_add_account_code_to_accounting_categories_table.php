<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounting_categories', function (Blueprint $table) {
            $table->string('account_code_payable')->nullable()->after('category_payable');
            $table->string('account_code_receivable')->nullable()->after('category_receivable');
        });
    }

    public function down(): void
    {
        Schema::table('accounting_categories', function (Blueprint $table) {
            $table->dropColumn(['account_code_payable', 'account_code_receivable']);
        });
    }
};