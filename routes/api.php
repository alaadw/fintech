<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/auth/register', [App\Http\Controllers\Api\AuthController::class, 'createUser']);
//http://sada.local/api/auth/login
Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'loginUser']);

//http://sada.local/api/listtransactions
Route::get('/listtransactions', [App\Http\Controllers\Api\TransactionsController::class, 'listTransactions'])-> middleware('auth:sanctum');
Route::post('/store', [App\Http\Controllers\Api\TransactionsController::class, 'store'])-> middleware('auth:sanctum');

  
