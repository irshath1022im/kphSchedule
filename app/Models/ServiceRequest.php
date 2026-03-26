<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'service_request_date',
        'service_request_time',
        'service_end_date',
        'service_end_time',
        'service_location',
        'status',
        'notes',
    ];
}
