<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/add', [App\Http\Controllers\TransactionController::class, 'add'])->middleware(['auth'])->name('addtransaction');
Route::post('/store', [App\Http\Controllers\TransactionController::class, 'store'])->middleware(['auth'])->name('storetransaction');
Route::get('/', [App\Http\Controllers\TransactionController::class, 'index'])->middleware(['auth'])->name('listoftransactions');
Route::any('/withpaypal', [App\Http\Controllers\PaypalController::class, 'pay'])->middleware(['auth'])->name('paypal');
