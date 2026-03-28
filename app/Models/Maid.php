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
}
