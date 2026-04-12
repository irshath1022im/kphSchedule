<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaidAssignment extends Model
{
    /** @use HasFactory<\Database\Factories\MaidAssignmentFactory> */
    use HasFactory;

    public function maid()
    {
        return $this->belongsTo(Maid::class, 'maid_id');
    }

    public function serviceRequestPeriod()
    {
        return $this->belongsTo(ServiceRequestPeriod::class, 'service_request_period_id');
    }

    protected $fillable = [
        'maid_id',
        'date',
        'service_request_period_id',
        'notes',
        'status',
    ];

}
