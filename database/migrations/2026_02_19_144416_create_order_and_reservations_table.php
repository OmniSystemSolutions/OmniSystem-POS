<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_and_reservations', function (Blueprint $table) {
            $table->id();

            $table->string('reference_number')->unique();

            // Relationship to customers table
            $table->foreignId('customer_id')
                    ->constrained('customers')
                    ->cascadeOnDelete();

            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->text('special_request')->nullable();

            $table->enum('status', ['pending', 'processed', 'archived'])
                    ->default('pending');

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_and_reservations');
    }
};
