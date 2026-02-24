<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_and_reservations', function (Blueprint $table) {
            $table->string('type_of_reservation')->nullable()->after('customer_id');
            $table->unsignedInteger('number_of_guest')->nullable()->after('reservation_time');
            $table->decimal('downpayment_amount', 10, 2)->default(0)->after('number_of_guest');

            // Foreign key to payments table4
            $table->unsignedBigInteger('payment_method_id')->nullable()->after('downpayment_amount');
            $table->foreign('payment_method_id')
                  ->references('id')
                  ->on('payments')
                  ->onDelete('set null');

            // Foreign key to cash_equivalents table
            $table->foreignId('cash_equivalent_id')->nullable()->after('payment_method_id')
                  ->constrained('cash_equivalents')
                  ->onDelete('set null');

            $table->decimal('gross_amount', 10, 2)->default(0)->after('cash_equivalent_id');
        });
    }

    public function down(): void
    {
        Schema::table('order_and_reservations', function (Blueprint $table) {
            // Drop foreign keys first before dropping columns
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['cash_equivalent_id']);

            $table->dropColumn([
                'type_of_reservation',
                'number_of_guest',
                'downpayment_amount',
                'payment_method_id',
                'cash_equivalent_id',
                'gross_amount',
            ]);
        });
    }
};