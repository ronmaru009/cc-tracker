<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    //
    protected $fillable = [

        'biller_id',
        'amount',
        'due_date',
        'is_paid'
    ];

    public function biller()
    {
        return $this->belongsTo(
            Biller::class
        );
    }
}
