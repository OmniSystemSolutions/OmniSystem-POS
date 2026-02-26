<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounting_categories', function (Blueprint $table) {
            if (Schema::hasColumn('accounting_categories', 'type')) {
                $table->dropColumn('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('accounting_categories', function (Blueprint $table) {
            $table->string('type')->nullable()->after('account_code');
        });
    }
};