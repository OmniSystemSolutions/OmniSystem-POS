<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 1: Add branch_id column (nullable first so existing rows don't fail)
        Schema::table('order_and_reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('id');
        });

        // STEP 2: Backfill existing rows with a default branch (branch_id = 1)
        DB::table('order_and_reservations')->update(['branch_id' => 1]);

        // STEP 3: Make it NOT NULL with a default of 1
        Schema::table('order_and_reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')
                  ->nullable(false)
                  ->default(1)
                  ->change();
        });

        // STEP 4: Add foreign key constraint
        Schema::table('order_and_reservations', function (Blueprint $table) {
            $table->foreign('branch_id')
                  ->references('id')
                  ->on('branches')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('order_and_reservations', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};