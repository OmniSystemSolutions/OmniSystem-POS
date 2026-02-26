<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountingSubCategory extends Model
{
    use HasFactory;

    protected $table = 'accounting_sub_categories';

    protected $fillable = [
        'accounting_category_id',
        'sub_category',
        'account_code',
        'status',
        'created_by',
    ];

    /**
     * Display label: "100 – Current Assets"
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->account_code
            ? "{$this->account_code} – {$this->sub_category}"
            : ($this->sub_category ?? '');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AccountingCategory::class, 'accounting_category_id');
    }
}