<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAndReservation extends Model
{
    protected $fillable = [
        'branch_id',
        'reference_number',
        'customer_id',
        'type_of_reservation',
        'reservation_date',
        'reservation_time',
        'number_of_guest',
        'downpayment_amount',
        'payment_method_id',
        'cash_equivalent_id',
        'special_request',
        'gross_amount',
        'status',
        'created_by',
    ];

    protected $casts = [
        'reservation_date'   => 'date',
        'downpayment_amount' => 'decimal:2',
        'gross_amount'       => 'decimal:2',
    ];

    // ─── Relationships ────────────────────────────────────────────
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function details()
    {
        return $this->hasMany(OrderReservationDetail::class, 'order_and_reservations_id');
    }

    /**
     * The payment method (links to the `payments` table).
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_method_id');
    }

    /**
     * The cash equivalent / payment destination (links to `cash_equivalents` table).
     */
    public function cashEquivalent()
    {
        return $this->belongsTo(CashEquivalent::class, 'cash_equivalent_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}