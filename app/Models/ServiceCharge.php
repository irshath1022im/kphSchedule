<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
{
    //
    protected $fillable = [
        'service_request_id',
        'invoice_date',
        'material_consumption',
        'description',
        'amount',
        'receipt_no',
        'payment_method',

    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
