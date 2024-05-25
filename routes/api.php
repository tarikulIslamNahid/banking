<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'auth'], function (){

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function (){

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('checkToken', [AuthController::class, 'checkToken']);
    });
});
