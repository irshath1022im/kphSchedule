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
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function serviceRequestPeriods()
    {
        return $this->hasMany(ServiceRequestPeriod::class, 'request_id');
    }

}
