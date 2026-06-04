<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Debt::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric',
            'minimum_payment' => 'required|numeric',
            'interest_rate' => 'nullable|numeric',
        ]);

        $debt = Debt::create($validated);

        return response()->json([
            'message' => 'Debt created successfully',
            'data' => $debt
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Debt $debt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debt $debt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Debt $debt)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric',
            'minimum_payment' => 'required|numeric',
            'interest_rate' => 'nullable|numeric',
        ]);

        $debt->update($validated);

        return response()->json([
            'message' => 'Debt updated successfully',
            'data' => $debt
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debt $debt)
    {
        $debt->delete();

        return response()->json([
            'message' => 'Debt deleted successfully'
        ], 200);
    }
}
