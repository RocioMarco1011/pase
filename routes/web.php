<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrevenirController;
use App\Http\Controllers\EstrategiasPrevenirController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
});

Route::group(['middleware' => 'auth'], function () {
Route::resource('users', \App\Http\Controllers\UsersController::class);
});

Route::group(['middleware' => 'auth'], function () {
Route::resource('estrategiasprevenir', \App\Http\Controllers\EstrategiasPrevenirController::class);
});
