<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartAccount extends Model
{
    use HasFactory;

    protected $table = 'chart_accounts';

    protected $fillable = [
        'accounting_category_id',
        'accounting_subcategory_id',
        'code',
        'name',
        'classification',
        'tax_mapping',
        'status',
        'created_by',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'status' => 'string',
        'classification' => 'string',
    ];

    /**
     * Scope: Active accounts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Relationships (optional if you have these tables)
     */
    public function category()
    {
        return $this->belongsTo(AccountingCategory::class, 'accounting_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(AccountingSubcategory::class, 'accounting_subcategory_id');
    }

    /**
     * Helper: Check if Debit
     */
    public function isDebit()
    {
        return $this->classification === 'debit';
    }

    /**
     * Helper: Check if Credit
     */
    public function isCredit()
    {
        return $this->classification === 'credit';
    }
}
