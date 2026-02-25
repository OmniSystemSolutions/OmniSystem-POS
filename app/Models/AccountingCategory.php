<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'account_code',
        'type',
        'created_by',
        'status',
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

    /**
     * Display label for type: "100 – Current Assets"
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->account_code
            ? "{$this->account_code} – {$this->type}"
            : ($this->type ?? '');
    }

    public function payableDetails()
    {
        return $this->hasMany(AccountPayableDetail::class, 'accounting_category_id');
    }
}