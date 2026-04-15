<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
{
    //
    protected $fillable = [
        'service_request_id',
        'service_id',
        'service_date',
        'end_date',
        'material_consumption',
        'description',
        'worked_hours',
        'assigned_maids',
        'amount',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
