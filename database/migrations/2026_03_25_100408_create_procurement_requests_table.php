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
        Schema::create('procurement_requests', function (Blueprint $table) {
            $table->id();

        // Basic fields
        $table->string('reference_no')->unique();
        $table->string('proforma_reference_no')->nullable();
        $table->string('type');

        // ENUM
        $table->enum('origin', ['local', 'international']);

        // JSON field
        $table->json('details')->nullable();

        // Foreign keys
        $table->foreignId('requested_by')
              ->constrained('users')
              ->cascadeOnDelete();

        $table->foreignId('requesting_branch_id')
              ->constrained('branches')
              ->cascadeOnDelete();

        $table->foreignId('department_id')
              ->constrained('departments')
              ->cascadeOnDelete();

        // Other fields
        $table->string('attachment')->nullable();
        $table->text('remarks')->nullable();
        $table->string('status')->default('pending');

        // Custom datetime
        $table->dateTime('created_datetime')->nullable();

        // Laravel timestamps (optional but recommended)
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_requests');
    }
};
