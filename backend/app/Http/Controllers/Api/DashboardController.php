<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreditCard;
use App\Models\CreditCardRecord;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Bill;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $cards = CreditCard::all();

        $totalLoans =
            LoanPayment::where(
                'is_paid',
                false
        )->sum('amount');

        $totalBills =

        Bill::where(
            'is_paid',
            false
        )

        ->sum('amount');

       $totalDebt =

            CreditCard::all()

            ->sum(function ($card) {

                return

                    $card->records()

                    ->latest()

                    ->value('balance')

                    ?? 0;
            })

            +

            $totalLoans

            +

            $totalBills;

        $totalLimit =
            $cards->sum('credit_limit');

        $totalAvailable =
            $totalLimit - $totalDebt;

        $utilization =
            $totalLimit > 0

            ? round(
                ($totalDebt / $totalLimit) * 100,
                2
              )

            : 0;

        $cardTrends =

            CreditCardRecord::select(

                'month',

                DB::raw(
                    'SUM(balance)
                    as total'
                )
            )

            ->groupBy('month')

            ->get();

        $loanTrends =

            LoanPayment::select(

                DB::raw("
                    DATE_FORMAT(
                        due_date,
                        '%Y-%m'
                    ) as month
                "),

                DB::raw(
                    'SUM(amount)
                    as total'
                )
            )

            ->where(
                'is_paid',
                false
            )

            ->whereYear(
                'due_date',
                now()->year
            )
            ->groupBy('month')
            ->get();

        $billTrends =

            Bill::select(

                DB::raw("
                    DATE_FORMAT(
                        due_date,
                        '%Y-%m'
                    ) as month
                "),

                DB::raw(
                    'SUM(amount)
                    as total'
                )
            )

            ->where(
                'is_paid',
                false
            )
            ->whereYear(
                'due_date',
                now()->year
            )
            ->groupBy('month')
            
            ->get();

        $monthlyDebtTrend =

            collect()

            ->merge($cardTrends)

            ->merge($loanTrends)

            ->merge($billTrends)

            ->groupBy('month')

            ->map(function ($items, $month) {

                return [

                    'month' => $month,

                    'total_balance' =>

                        $items->sum('total')
                ];
            })

            ->values();

        $totalBills =

            Bill::where(
                'is_paid',
                false
            )

        ->sum('amount');

        $creditCardDueDates =

    CreditCard::all()

    ->map(function ($card) {

        $latestRecord =

            $card->records()
                ->latest()
                ->first();

        if (
            !$latestRecord ||
            !$latestRecord->due_date
        ) {

            return null;
        }

        $dueDate =

            \Carbon\Carbon::parse(
                $latestRecord->due_date
            );

        $dueInDays =

            now()

            ->startOfDay()

            ->diffInDays(

                $dueDate->startOfDay(),

                false
            );

        return [

            'type' => 'card',

            'card_name' =>

                $card->name,

            'due_date' =>

                $latestRecord->due_date,

            'due_in_days' =>

                $dueInDays,

            'amount_due' =>

                $latestRecord->balance
                ?? 0,

            'statement_date' =>

                now()

                ->copy()

                ->day(
                    $card->billing_day
                )

                ->toDateString(),
        ];
    })

    ->filter()

    ->sortBy('due_in_days')

    ->values();

$loanDueDates =

    LoanPayment::with('loan')

    ->where(
        'is_paid',
        false
    )

    ->get()

    ->map(function ($payment) {

        return [

            'type' => 'loan',

            'loan_name' =>

                $payment->loan
                    ->loan_name,

            'due_date' =>

                $payment->due_date,

            'amount_due' =>

                $payment->amount,

           'due_in_days' =>

            (int)
            now()
            ->startOfDay()
            ->diffInDays(
                \Carbon\Carbon::parse(
                    $payment->due_date
                )->startOfDay(),
                false
            )
        ];
    });

    $billDueDates =

    Bill::with('biller')

    ->where(
        'is_paid',
        false
    )

    ->get()

    ->map(function ($bill) {

        return [

            'type' => 'bill',

            'bill_name' =>

                $bill->biller
                    ->name,

            'due_date' =>

                $bill->due_date,

            'amount_due' =>

                $bill->amount,

            'due_in_days' =>

                (int)

                now()

                ->startOfDay()

                ->diffInDays(

                    \Carbon\Carbon::parse(
                        $bill->due_date
                    )->startOfDay(),

                    false
                )
        ];
    });

    $upcomingDueDates =

    $creditCardDueDates

    ->concat(
        $loanDueDates
    )

    ->concat(
        $billDueDates
    )

    ->filter(function ($due) {

        return

            $due['due_in_days'] <= 15;
    })

    ->sortBy(function ($due) {

    return

        \Carbon\Carbon::parse(
            $due['due_date']
        )->timestamp;
})

    ->values();
    
        return response()->json([

            'totalDebt' => $totalDebt,
            'totalLimit' => $totalLimit,
            'totalAvailable' => $totalAvailable,
            'utilization' => $utilization,
            'monthlyDebtTrend' => $monthlyDebtTrend,
            'upcomingDueDates' => $upcomingDueDates,
            'totalLoans' => $totalLoans,
            'totalBills' => $totalBills,
            
        ]);
    }
}

