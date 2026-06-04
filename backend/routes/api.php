<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\Api\CreditCardRecordController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\BillController;

Route::post(
    'credit-card-records/{record}/pay',
    [CreditCardRecordController::class, 'pay']
);

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
);
Route::get(
    'billers',
    [BillController::class, 'billers']
);


Route::patch(
    'loan-payments/{loanPayment}/toggle',
    [LoanController::class, 'togglePayment']
);
Route::patch(
    'loan-payments/{loanPayment}',
    [LoanController::class, 'updatePayment']
);
Route::patch(
    'bills/{bill}/toggle',
    [BillController::class, 'toggle']
);

Route::post(
    'billers',
    [BillController::class, 'storeBiller']
);

Route::delete(
    'billers/{biller}',
    [BillController::class, 'destroyBiller']
);

Route::apiResource('loans',LoanController::class);
Route::apiResource('debts', DebtController::class);
Route::apiResource('credit-cards', CreditCardController::class);
Route::apiResource('credit-card-records', CreditCardRecordController::class);
Route::apiResource('bills', App\Http\Controllers\Api\BillController::class);
