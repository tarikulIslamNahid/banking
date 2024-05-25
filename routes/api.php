<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'auth'], function (){

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function (){

        Route::get('/logout', [AuthController::class, 'logout']);
    });
});

Route::group(['middleware' => 'auth:sanctum','prefix'=>'transaction'], function (){

    Route::get('/', [TransactionsController::class, 'getTransactions']);
    Route::get('deposit', [TransactionsController::class, 'getDepositTransactions']);
    Route::get('withdrawal', [TransactionsController::class, 'getWithdrawalTransactions']);
    Route::post('deposit', [TransactionsController::class, 'depositTransaction']);
});

