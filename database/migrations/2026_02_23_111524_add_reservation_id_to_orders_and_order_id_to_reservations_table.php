<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // was created from a reservation
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'reservation_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedBigInteger('reservation_id')
                      ->nullable()
                      ->after('cashier_id')
                      ->comment('Links POS order back to the source reservation');

                // Optional FK — comment out if order_and_reservations is a different DB
                $table->foreign('reservation_id')
                      ->references('id')
                      ->on('order_and_reservations')
                      ->nullOnDelete();
            });
        }

        // Add order_id to order_and_reservations so we can quickly jump to the POS order
        if (!Schema::hasColumn('order_and_reservations', 'order_id')) {
            Schema::table('order_and_reservations', function (Blueprint $table) {
                $table->unsignedBigInteger('order_id')
                      ->nullable()
                      ->after('status')
                      ->comment('The POS Order created when moved to Ready for Service');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'reservation_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['reservation_id']);
                $table->dropColumn('reservation_id');
            });
        }

        if (Schema::hasColumn('order_and_reservations', 'order_id')) {
            Schema::table('order_and_reservations', function (Blueprint $table) {
                $table->dropColumn('order_id');
            });
        }
    }
};