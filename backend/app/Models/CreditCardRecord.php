<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCardRecord extends Model
{
    //
    protected $fillable = [
        'credit_card_id',
        'month',
        'balance',
        'minimum_due',
        'due_date',  
        'payment_amount',
        'payment_date',
        'points_earned',
        'remarks'
    ];

    public function creditCard()
    {
        return $this->belongsTo(CreditCard::class);
    }
}
