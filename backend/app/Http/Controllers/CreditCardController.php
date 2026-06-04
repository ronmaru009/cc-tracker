<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use Illuminate\Http\Request;

class CreditCardController extends Controller
{
    public function index()
    {
        return CreditCard::all();
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
            'name' => 'required',
            'card_last_four' => 'required',
            'card_image' => 'nullable',
            'credit_limit' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'billing_day' => 'nullable|numeric',
            'due_day' => 'nullable|numeric',
            'start_date' => 'nullable|date',
        ]);

        return CreditCard::create($validated);
    }

    public function show(CreditCard $creditCard)
{
    $creditCard->load('records');
   
    $latestBalance =
        $creditCard->records()
        ->latest()
        ->value('balance')
        ?? 0;

    return response()->json([
        'card' =>
            $creditCard,
        'latest_balance' =>
            $latestBalance
    ]);
}

    public function update(Request $request, $id)
    {
        $card = CreditCard::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'card_last_four' => 'required',
            'card_image' => 'nullable',
            'credit_limit' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'minimum_due' => 'nullable|numeric',
            'billing_day' => 'nullable|numeric',
            'due_day' => 'nullable|numeric',
            'start_date' => 'nullable|date',
        ]);
        $card->update($validated);
        return $card;
    }

    public function destroy($id)
    {
        $card = CreditCard::findOrFail($id);
        $card->delete();
        return response()->json(null, 204);
    }
}
