<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BranchProduct extends Model
{
    use HasFactory;

    protected $table = 'branch_products';

    protected $fillable = [
        'branch_id',
        'product_id',
        'station_id',
        'unit_id',
        'quantity',
        'price',
        'status',
        'type', // simple | bundle
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
    ];

    /* ======================
     |  Relationships
     |======================*/

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
