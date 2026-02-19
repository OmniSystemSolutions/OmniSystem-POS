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
        Schema::create('bundle_items', function (Blueprint $table) {
            // Bundle Product (parent)
            $table->foreignId('bundle_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // Child Product inside the bundle
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // Quantity of child product inside bundle
            $table->integer('quantity')->default(1);

            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['bundle_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_items');
    }
};
