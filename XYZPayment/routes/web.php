<?php

use App\Http\Controllers\PaymentController;
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

/*
Route::get('/',function () {
//    return redirect('/form');
});
*/

Route::get('/form', function () {
    return view('form');
});

Route::post('/form',[PaymentController::class,'form'])->name('form');
Route::get('/pay',[PaymentController::class,'pay'])->name('pay');
Route::post('/input',[PaymentController::class,'input'])->name('input');


