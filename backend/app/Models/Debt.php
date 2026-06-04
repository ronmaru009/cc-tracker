<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    //
    protected $fillable = [
        'name',
        'balance',
        'minimum_payment',
        'interest_rate',
    ];
}


