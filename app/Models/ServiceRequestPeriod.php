<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestPeriod extends Model
{
    //
    use HasFactory;
    protected $fillable=[
        'request_id',
        'service_id',
        'start_date',
        'day_of_week',
        'start_time',
        'duration_hours',
        'status'
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'request_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function maidAssignments()
    {
        return $this->hasMany(MaidAssignment::class, 'service_request_period_id');
    }

}
