<?php

use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Route;
use Laravel\Telescope\Http\Controllers\HomeController;

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

Route::get('/',[HomeController::class,'index']);

Route::get('/app', function () {
    return view('layouts.app');
});
/*
Route::get('/app/{any}', function () {
    return view('layouts.app');
})->middleware('auth');
*/
Route::get('/app/{any}', function () {
    return view('layouts.app');
})->where('any', '^(?!api).*$');;

Route::get('/logout', [LoginController::class,'logout'])->name('logout');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
