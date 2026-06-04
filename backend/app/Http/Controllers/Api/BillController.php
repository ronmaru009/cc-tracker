<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Biller;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    return Bill::with(
        'biller'
    )->get();
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated =
        $request->validate([

            'biller_id' =>
                'required',

            'amount' =>
                'required|numeric',

            'due_date' =>
                'required|date'
        ]);

    return Bill::create(
        $validated
    );
}
public function storeBiller(Request $request)
{
    $validated =
        $request->validate([

            'name' =>
                'required'
        ]);

    return Biller::create(
        $validated
    );
}

public function destroyBiller(Biller $biller){
    $biller->delete();
    return response()->json([
        'message' => 'Deleted'
    ]);
}

public function toggle(Bill $bill)
{
    $bill->update([

        'is_paid' =>

            !$bill->is_paid
    ]);

    return $bill;
}

public function billers()
{
    return Biller::all();
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
}
