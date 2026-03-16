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
             // Add sr_pwd_bill after gross_amount
            $table->decimal('sr_pwd_bill', 12, 2)
                  ->default(0)
                  ->after('gross_amount')
                  ->comment('SR/PWD portion of the bill');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
             $table->dropColumn('sr_pwd_bill');
        });
    }
};
