<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'service_request_date',
        'client_id',
        'frequency',
        'notes',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function serviceRequestPeriods()
    {
        return $this->hasMany(ServiceRequestPeriod::class, 'request_id');
    }

    public function services()
    {
        return $this->hasManyThrough(Service::class, ServiceRequestPeriod::class, 'request_id', 'id', 'id', 'service_id');
    }

    public function getTotalHoursAttribute()
    {
        return $this->serviceRequestPeriods()->sum('duration_hours');
    }

    public function getTotalQuotationValueAttribute()
    {
        return $this->serviceRequestPeriods()->sum('quotation_value');
    }

    public function assignedMaids()
    {
        return $this->hasManyThrough(MaidAssignment::class, ServiceRequestPeriod::class, 'request_id', 'service_request_period_id', 'id', 'id');
    }

    public function serviceCharges()
    {
        return $this->hasMany(ServiceCharge::class);
    }

}
