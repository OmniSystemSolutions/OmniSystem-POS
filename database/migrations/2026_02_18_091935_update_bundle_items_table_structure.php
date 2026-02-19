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
        Schema::table('bundle_items', function (Blueprint $table) {

            // 1️⃣ Drop foreign key on product_id (if exists)
            $table->dropForeign(['product_id']);

            // 2️⃣ Rename product_id → item_id
            $table->renameColumn('product_id', 'item_id');

            // 3️⃣ Add item_type column
            $table->string('item_type')->after('item_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('bundle_items', function (Blueprint $table) {

            // Reverse changes
            $table->renameColumn('item_id', 'product_id');
            $table->dropColumn('item_type');

            // Re-add foreign key (optional, only if it existed before)
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->cascadeOnDelete();
        });
    }
};
