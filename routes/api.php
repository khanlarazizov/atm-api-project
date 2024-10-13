<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WithdrawController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BanknoteController;

Route::post('auth/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('accounts', [AccountController::class, 'show']);

    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'show']);
        Route::post('withdraw', WithdrawController::class);
        Route::delete('{transactionId}', [TransactionController::class, 'destroy'])->middleware('delete_own_transaction');
    });

    Route::middleware('admin')
        ->apiResource('banknotes', BanknoteController::class)
        ->only('index', 'show', 'update');
});

