<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;

Route::middleware('auth:api')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

