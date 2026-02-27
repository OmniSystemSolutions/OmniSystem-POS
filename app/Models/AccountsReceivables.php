<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountsReceivables extends Model
{
    use HasFactory;

    protected $table = 'accounts_receivables';

    protected $fillable = [
        'reference_no',
        'branch_id',
        'user_id',
        'transaction_datetime',
        'transaction_type',
        'payor_name',
        'company',
        'address',
        'mobile_no',
        'email',
        'tin',
        'due_date',

        // Totals — added via migration
        'sub_total',
        'total_tax',
        'total_amount',

        // Payment tracking
        'amount_due',
        'total_received',
        'balance',

        // Status
        'status',
        'approved_by',    'approved_at',
        'completed_by',   'completed_at',
        'disapproved_by', 'disapproved_at',
        'archived_by',    'archived_at',
    ];

    public function items()
    {
        return $this->hasMany(AccountsReceivableDetail::class, 'accounts_receivable_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(AccountsReceivablesPayment::class, 'account_receivable_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }

    public function approvedBy()    { return $this->belongsTo(User::class, 'approved_by'); }
    public function completedBy()   { return $this->belongsTo(User::class, 'completed_by'); }
    public function disapprovedBy() { return $this->belongsTo(User::class, 'disapproved_by'); }
    public function archivedBy()    { return $this->belongsTo(User::class, 'archived_by'); }

    public function chartAccounts()
    {
        return $this->hasManyThrough(
            ChartAccount::class,
            AccountsReceivableDetail::class,
            'accounts_receivable_id',
            'id',
            'id',
            'chart_account_id'
        );
    }

    protected static function booted()
    {
        static::creating(function ($ar) {
            $user = auth()->user();
            if ($user) {
                $branch = $user->branches()->first();
                if ($branch) {
                    $ar->branch_id = $branch->id;
                }
            }
        });
    }
}