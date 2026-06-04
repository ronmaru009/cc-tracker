<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    //
    protected $fillable = [
        'loan_id',
        'payment_month',
        'due_date',
        'amount',
        'is_paid'
    ];
    public function loan()
    {
        return $this->belongsTo(
            Loan::class
        );
    }
}
