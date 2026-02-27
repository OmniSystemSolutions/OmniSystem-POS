<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsReceivableDetail extends Model
{
    use HasFactory;

    protected $table = 'accounts_receivable_details';

    protected $fillable = [
        'accounts_receivable_id',
        'chart_account_id',
        'type_id',
        'description',
        'qty',
        'unit_price',
        'tax',          // string: VAT / NON-VAT / ZERO-RATED
        'tax_id',       // legacy FK (kept for old records)
        'tax_amount',
        'sub_total',
        'total_amount',
    ];

    // ─────────────────────────────────────────────
    // RELATIONSHIPS
    // ─────────────────────────────────────────────

    public function receivable()
    {
        return $this->belongsTo(AccountsReceivables::class, 'accounts_receivable_id');
    }

    /**
     * Chart account this line item is linked to.
     */
    public function chartAccount()
    {
        return $this->belongsTo(ChartAccount::class, 'chart_account_id');
    }

    /**
     * Sub category (from accounting_sub_categories).
     */
    public function type()
    {
        return $this->belongsTo(AccountingSubCategory::class, 'type_id');
    }

    // ─────────────────────────────────────────────
    // ACCESSOR — resolve tax label from either column
    // ─────────────────────────────────────────────

    /**
     * Returns a consistent tax label regardless of whether the row
     * was saved with the old tax_id or the new tax string column.
     */
    public function getTaxLabelAttribute(): string
    {
        if (!empty($this->tax)) {
            return strtoupper($this->tax);
        }

        // Fallback: resolve from tax_id if your taxes table exists
        // return $this->taxType?->name ?? 'NON-VAT';

        return 'NON-VAT';
    }
}