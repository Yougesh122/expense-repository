<?php

use Illuminate\Support\Facades\Route;
use Modules\Expense\Http\Controllers\Api\ExpenseController;

// Route::prefix('v1')->group(function () {
//     Route::apiResource('expenses', ExpenseController::class)->names('expense');
// });

Route::prefix('v1/expenses')->group(function () {
    Route::get('/{id}', [ExpenseController::class, 'show']);
    Route::get('/', [ExpenseController::class, 'index']);
    Route::post('/', [ExpenseController::class, 'store']);
    Route::post('/{id}', [ExpenseController::class, 'update']);
    Route::delete('/{id}', [ExpenseController::class, 'destroy']);
});
