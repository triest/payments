<?php


use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
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

Route::post('create',[PaymentController::class,'create']);
Route::get('get-status',[PaymentController::class,'getStatus']);

Route::post('form',[PaymentController::class,'form']);

Route::apiResource('orders',OrderController::class)->only('index');

