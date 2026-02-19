<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BundleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle_id', 'item_id', 'item_type', 'quantity',
    ];

    public function bundle()
    {
        return $this->belongsTo(Product::class, 'bundle_id');
    }

    /**
     * Actual item (product or component)
     */
    public function item()
    {
        return $this->morphTo(__FUNCTION__, 'item_type', 'item_id');
    }
}
