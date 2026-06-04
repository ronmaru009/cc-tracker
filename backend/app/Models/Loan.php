<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //
    protected $fillable = [

        'loan_name',
        'total_amount',
        'start_date',
        'end_date',
        'due_day',
        'monthly_amortization'
    ];

    public function payments()
    {
        return $this->hasMany(
            LoanPayment::class
        );
    }
}
