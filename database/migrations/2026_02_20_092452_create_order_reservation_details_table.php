<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_reservation_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_and_reservations_id')
                  ->constrained('order_and_reservations')
                  ->cascadeOnDelete();

            // Either a product or a component (one will be null)
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('component_id')->nullable();

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->nullOnDelete();

            $table->foreign('component_id')
                  ->references('id')
                  ->on('components')
                  ->nullOnDelete();

            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->text('notes')->nullable();

            $table->enum('status', ['serving', 'done', 'cancelled', 'pending'])
                  ->default('serving');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_reservation_details');
    }
};