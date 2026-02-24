<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Expand enum to include BOTH old and new values simultaneously
        // so MySQL accepts the existing rows AND the new values during data migration
        DB::statement("
            ALTER TABLE order_and_reservations
            MODIFY COLUMN status ENUM('pending', 'processed', 'archived', 'reservations', 'prepared_service', 'ready_for_service')
            NOT NULL DEFAULT 'pending'
        ");

        // Step 2: Migrate existing data to new values (now safe — all values exist in enum)
        DB::table('order_and_reservations')
            ->where('status', 'pending')
            ->update(['status' => 'reservations']);

        DB::table('order_and_reservations')
            ->where('status', 'processed')
            ->update(['status' => 'prepared_service']);

        DB::table('order_and_reservations')
            ->where('status', 'archived')
            ->update(['status' => 'ready_for_service']);

        // Step 3: Now remove the old enum values, set new default
        DB::statement("
            ALTER TABLE order_and_reservations
            MODIFY COLUMN status ENUM('reservations', 'prepared_service', 'ready_for_service')
            NOT NULL DEFAULT 'reservations'
        ");
    }

    public function down(): void
    {
        // Step 1: Expand to include both old and new values
        DB::statement("
            ALTER TABLE order_and_reservations
            MODIFY COLUMN status ENUM('pending', 'processed', 'archived', 'reservations', 'prepared_service', 'ready_for_service')
            NOT NULL DEFAULT 'reservations'
        ");

        // Step 2: Revert data back to old values
        DB::table('order_and_reservations')
            ->where('status', 'reservations')
            ->update(['status' => 'pending']);

        DB::table('order_and_reservations')
            ->where('status', 'prepared_service')
            ->update(['status' => 'processed']);

        DB::table('order_and_reservations')
            ->where('status', 'ready_for_service')
            ->update(['status' => 'archived']);

        // Step 3: Restore original enum only
        DB::statement("
            ALTER TABLE order_and_reservations
            MODIFY COLUMN status ENUM('pending', 'processed', 'archived')
            NOT NULL DEFAULT 'pending'
        ");
    }
};