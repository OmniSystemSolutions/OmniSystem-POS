<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'account_code',
        'status',
        'created_by',
    ];

    /**
     * Display label: "1000 – Assets" or just "Assets"
     */
    public function getCategoryLabelAttribute(): string
    {
        return $this->account_code
            ? "{$this->account_code} – {$this->category}"
            : ($this->category ?? '');
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(AccountingSubCategory::class, 'accounting_category_id');
    }

    public function activeSubCategories(): HasMany
    {
        return $this->subCategories()->where('status', 'active');
    }

    public function payableDetails(): HasMany
    {
        return $this->hasMany(AccountPayableDetail::class, 'accounting_category_id');
    }

    public function chartAccounts()
    {
        return $this->hasMany(
            ChartAccount::class,
            'accounting_category_id'
        );
    }
}