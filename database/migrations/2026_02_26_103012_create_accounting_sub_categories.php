<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── Step 1: Fix FK on accounts_receivable_details ──
        try {
            Schema::table('accounts_receivable_details', function (Blueprint $table) {
                $table->dropForeign(['type_id']);
                $table->foreign('type_id')
                      ->references('id')
                      ->on('accounting_categories')
                      ->nullOnDelete();
            });
        } catch (\Exception $e) {
            // FK may not exist or already updated — skip
        }

        // ── Step 2: Fix FK on account_payable_details ──
        try {
            Schema::table('account_payable_details', function (Blueprint $table) {
                $table->dropForeign(['accounting_category_id']);
                $table->foreign('accounting_category_id')
                      ->references('id')
                      ->on('accounting_categories')
                      ->nullOnDelete();
            });
        } catch (\Exception $e) {
            // FK may not exist or already updated — skip
        }

        // ── Step 3: Re-point any detail rows that reference type rows ──
        // to their parent category ID before we delete the type rows
        $typeRows = DB::table('accounting_categories')
            ->whereNotNull('type')
            ->get();

        foreach ($typeRows as $row) {
            $parent = DB::table('accounting_categories')
                ->whereNull('type')
                ->where('category', $row->category)
                ->orderBy('id')
                ->first();

            if ($parent) {
                DB::table('accounts_receivable_details')
                    ->where('type_id', $row->id)
                    ->update(['type_id' => $parent->id]);

                DB::table('account_payable_details')
                    ->where('accounting_category_id', $row->id)
                    ->update(['accounting_category_id' => $parent->id]);
            }
        }

        // ── Step 4: Create accounting_sub_categories table ──
        if (!Schema::hasTable('accounting_sub_categories')) {
            Schema::create('accounting_sub_categories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('accounting_category_id')
                      ->constrained('accounting_categories')
                      ->cascadeOnDelete();
                $table->string('sub_category');
                $table->string('account_code')->nullable();
                $table->enum('status', ['active', 'archived'])->default('active');
                $table->foreignId('created_by')
                      ->nullable()
                      ->constrained('users')
                      ->nullOnDelete();
                $table->timestamps();
            });
        }

        // ── Step 5: Migrate type rows into accounting_sub_categories ──
        foreach ($typeRows as $row) {
            $parent = DB::table('accounting_categories')
                ->whereNull('type')
                ->where('category', $row->category)
                ->orderBy('id')
                ->first();

            if ($parent) {
                // Avoid duplicate inserts if migration was partially run before
                $alreadyExists = DB::table('accounting_sub_categories')
                    ->where('accounting_category_id', $parent->id)
                    ->whereRaw('LOWER(sub_category) = ?', [strtolower($row->type)])
                    ->exists();

                if (!$alreadyExists) {
                    DB::table('accounting_sub_categories')->insert([
                        'accounting_category_id' => $parent->id,
                        'sub_category'           => $row->type,
                        'account_code'           => $row->account_code ?? null,
                        'status'                 => $row->status ?? 'active',
                        'created_by'             => $row->created_by ?? null,
                        'created_at'             => $row->created_at,
                        'updated_at'             => $row->updated_at,
                    ]);
                }
            }
        }

        // ── Step 6: Delete type rows from accounting_categories ──
        DB::table('accounting_categories')->whereNotNull('type')->delete();

        // ── Step 7: Drop the type column ──
        if (Schema::hasColumn('accounting_categories', 'type')) {
            Schema::table('accounting_categories', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }

    public function down(): void
    {
        // Restore type column
        if (!Schema::hasColumn('accounting_categories', 'type')) {
            Schema::table('accounting_categories', function (Blueprint $table) {
                $table->string('type')->nullable()->after('account_code');
            });
        }

        // Move sub categories back into accounting_categories
        $subCategories = DB::table('accounting_sub_categories')
            ->join('accounting_categories',
                'accounting_sub_categories.accounting_category_id',
                '=',
                'accounting_categories.id'
            )
            ->select(
                'accounting_categories.category',
                'accounting_sub_categories.sub_category as type',
                'accounting_sub_categories.account_code',
                'accounting_sub_categories.status',
                'accounting_sub_categories.created_by',
                'accounting_sub_categories.created_at',
                'accounting_sub_categories.updated_at'
            )
            ->get();

        foreach ($subCategories as $row) {
            DB::table('accounting_categories')->insert([
                'category'     => $row->category,
                'account_code' => $row->account_code,
                'type'         => $row->type,
                'status'       => $row->status,
                'created_by'   => $row->created_by,
                'created_at'   => $row->created_at,
                'updated_at'   => $row->updated_at,
            ]);
        }

        Schema::dropIfExists('accounting_sub_categories');

        // Restore restrictive FKs
        try {
            Schema::table('accounts_receivable_details', function (Blueprint $table) {
                $table->dropForeign(['type_id']);
                $table->foreign('type_id')
                      ->references('id')
                      ->on('accounting_categories')
                      ->restrictOnDelete();
            });
        } catch (\Exception $e) {
            //
        }

        try {
            Schema::table('account_payable_details', function (Blueprint $table) {
                $table->dropForeign(['accounting_category_id']);
                $table->foreign('accounting_category_id')
                      ->references('id')
                      ->on('accounting_categories')
                      ->restrictOnDelete();
            });
        } catch (\Exception $e) {
            //
        }
    }
};