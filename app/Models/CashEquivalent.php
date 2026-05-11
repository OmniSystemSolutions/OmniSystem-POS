<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashEquivalent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_number',
        'type_of_account',
        'conversion_in_peso',
        'created_by',
        'status',
        'accountable_id',
    ];

    /**
     * Get the user who created this cash equivalent.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function accountable()
    {
        return $this->belongsTo(User::class, 'accountable_id');
    }
}
