<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'mode',                    // payable or receivable
        'category_payable',        // enum list for payable
        'category_receivable',     // enum list for receivable
        'account_code_payable',
        'account_code_receivable',
        'type_payable',
        'type_receivable',
        'created_by',
        'status',
    ];

    /**
     * Get display label: "1000 – Assets"
     */
    public function getCategoryLabelAttribute(): string
    {
        if ($this->mode === 'payable') {
            return $this->account_code_payable
                ? "{$this->account_code_payable} – {$this->category_payable}"
                : $this->category_payable;
        }

        return $this->account_code_receivable
            ? "{$this->account_code_receivable} – {$this->category_receivable}"
            : $this->category_receivable;
    }

    /**
     * Get display label for type: "100 – Current Assets"
     */
    public function getTypeLabelAttribute(): string
    {
        if ($this->mode === 'payable') {
            return $this->account_code_payable
                ? "{$this->account_code_payable} – {$this->type_payable}"
                : ($this->type_payable ?? '');
        }

        return $this->account_code_receivable
            ? "{$this->account_code_receivable} – {$this->type_receivable}"
            : ($this->type_receivable ?? '');
    }

    public function payableDetails()
    {
        return $this->hasMany(AccountPayableDetail::class, 'accounting_category_id');
    }
}
