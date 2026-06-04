<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    //
    protected $fillable = [
    'name',
    'card_last_four',
    'card_image',
    'credit_limit',
    'interest_rate',
    'minimum_due',
    'billing_day',
    'due_day',
    'start_date'
];

    public function records()
    {
        return $this->hasMany(CreditCardRecord::class);
    }
}
