<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\CustomerController;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/customers', [CustomerController::class, 'index'])->name('web.customers.index');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('web.customers.create');
Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('web.customers.show');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('web.customers.edit');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
