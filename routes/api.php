<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// public routes
Route::post('/v1/login', [AuthController::class, 'login']);

// private routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/customer-address/store', [CustomerController::class, 'customerAddressStore']);
    Route::get('/customer-address/list', [CustomerController::class, 'customerAddressList']);
});

