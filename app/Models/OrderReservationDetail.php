<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReservationDetail extends Model
{
    protected $fillable = [
        'order_and_reservations_id',
        'product_id',
        'component_id',
        'quantity',
        'price',
        'discount',
        'notes',
        'status',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price'    => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function reservation()
    {
        return $this->belongsTo(OrderAndReservation::class, 'order_and_reservations_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    // ─── Accessors ────────────────────────────────────────────────

    /**
     * Returns the linked product OR component (whichever is set).
     */
    public function getItemAttribute()
    {
        return $this->product ?? $this->component;
    }

    /**
     * Subtotal after discount.
     */
    public function getSubtotalAttribute(): float
    {
        return ($this->quantity * $this->price) - $this->discount;
    }
}