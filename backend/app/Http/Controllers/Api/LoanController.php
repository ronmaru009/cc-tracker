<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanPayment;
use Carbon\Carbon;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Loan::with('payments')

    ->get()

    ->map(function ($loan) {

        $paid = $loan->payments
            ->where('is_paid', true)
            ->sum('amount');

        $remaining = $loan->payments
            ->where('is_paid',false)
            ->sum('amount');

        $loan->paid_amount = $paid;
        $loan->remaining_balance = $remaining;
        $loan->progress_percentage = $loan->total_amount > 0 ? 
            round(($paid / $loan->total_amount) * 100, 2) : 0;       
            return $loan;
        });
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validated = $request->validate([

            'loan_name' => 'required',
            'total_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'due_day' => 'required|integer'
        ]);

        $start = Carbon::parse(
            $validated['start_date']
        );

        $end = Carbon::parse(
            $validated['end_date']
        );

        $months =

            $start->diffInMonths($end) + 1;

        $monthlyAmortization =

            $validated['total_amount']
            / $months;

        $loan = Loan::create([

            ...$validated,

            'monthly_amortization' =>

                $monthlyAmortization
        ]);

        for ($i = 0; $i < $months; $i++) {

            $paymentMonth =

                $start->copy()
                    ->addMonths($i);

            $dueDate =

                $paymentMonth->copy()

                ->day(
                    $validated['due_day']
                );

            LoanPayment::create([

                'loan_id' =>

                    $loan->id,

                'payment_month' =>

                    $paymentMonth,

                'due_date' =>

                    $dueDate,

                'amount' =>

                    $monthlyAmortization,

                'is_paid' => false
            ]);
        }

        return $loan->load('payments');
    }

    public function togglePayment(LoanPayment $loanPayment)
    {
        $loanPayment->update([
            'is_paid' =>
                !$loanPayment->is_paid
        ]);
        return $loanPayment;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updatePayment(

        Request $request,

        LoanPayment $loanPayment

    )
    {
        $validated =
            $request->validate([

                'amount' =>
                    'required|numeric',

                'due_date' =>
                    'required|date'
            ]);

        $loanPayment->update(
            $validated
        );

        return $loanPayment;
    }
}
