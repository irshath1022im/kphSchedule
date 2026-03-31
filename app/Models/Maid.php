<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maid extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'name',
        'contact_info',
        'status',
    ];

    public function assignments()
    {
        return $this->hasMany(MaidAssignment::class, 'maid_id');
    }

    public function serviceRequestPeriods()
    {
        return $this->hasManyThrough(
            ServiceRequestPeriod::class,
            MaidAssignment::class,
            'maid_id', // Foreign key on MaidAssignment
            'id', // Foreign key on ServiceRequestPeriod
            'id', // Local key on Maid
            'service_request_period_id' // Local key on MaidAssignment
        );
    }
}
