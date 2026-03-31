<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementRequest extends Model
{
    use HasFactory;

    protected $table = 'procurement_requests';

    protected $fillable = [
        'reference_no',
        'proforma_reference_no',
        'type',
        'origin',
        'details',
        'requested_by',
        'requesting_branch_id',
        'department_id',
        'attachment',
        'remarks',
        'status',
        'created_datetime',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'details' => 'array', // auto JSON decode/encode
        'created_datetime' => 'datetime',
    ];

    /**
     * Relationships
     */

    public function createdBy() 
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Requested by (User)
    public function requestedBy() 
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    // Branch
    public function requestingBranch() 
    {
        return $this->belongsTo(Branch::class, 'requesting_branch_id');
    }

    // Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
