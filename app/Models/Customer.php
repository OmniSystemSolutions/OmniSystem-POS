<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_no',
        'customer_name',
        'company_name',
        'mobile_no',
        'landline_no',
        'email',
        'address',
        'assigned_personnel',
        'province',
        'city_municipality',
        'credit_limit',
        'payment_terms_days',
        'customer_type',
        'discount_id',
        'customer_since',
        'status'
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function reservations()
    {
        return $this->hasMany(OrderAndReservation::class);
    }
}
