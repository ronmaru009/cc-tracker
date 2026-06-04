<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreditCardRecord;
use Illuminate\Http\Request;

class CreditCardRecordController extends Controller
{
    public function index()
    {
        return CreditCardRecord::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'credit_card_id' => 'required',
            'month' => 'required',
            'balance' => 'required|numeric',
            'minimum_due' => 'nullable|numeric',
            'payment_amount' => 'nullable|numeric',
            'payment_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'points_earned' => 'nullable|numeric',
            'remarks' => 'nullable'
        ]);
        $record = CreditCardRecord::create($validated);
        return $record;
    }

    public function update(Request $request, CreditCardRecord $creditCardRecord)
    {
        $validated = $request->validate([

            'month' => 'required',
            'balance' => 'required|numeric',
            'minimum_due' => 'nullable|numeric',
            'payment_amount' => 'nullable|numeric',
            'payment_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'points_earned' => 'nullable|numeric',
            'remarks' => 'nullable'
        ]);

        $creditCardRecord
            ->update($validated);

        return $creditCardRecord;
    }

    public function destroy(CreditCardRecord $creditCardRecord)
    {
        $creditCardRecord->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }

   public function pay(
    Request $request,
    CreditCardRecord $record
)
{
    $validated =
        $request->validate([

            'payment_amount' =>

                'required|numeric|min:1'
        ]);

    $validated['payment_amount'] =

        $validated['payment_amount'] ?? 0;

    $validated['points_earned'] =

        $validated['points_earned'] ?? 0;

    // ADD PAYMENT TO RECORD

    $record->payment_amount +=
        $validated['payment_amount'];

    $record->payment_date =
        now();

    $record->remarks .=

        "\n\nPaid ₱" .

        $validated['payment_amount'] .

        ' on ' .

        now()->format('m/d/Y');

    $record->save();

    return response()->json([

        'message' =>
            'Payment applied'
    ]);
}
}