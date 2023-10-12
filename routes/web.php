<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrevenirController;
use App\Http\Controllers\EstrategiasPrevenirController;
use App\Http\Controllers\AccionPrevenirController;


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


// Rutas para las estrategias de prevención
Route::prefix('estrategiasprevenir')->group(function () {
    Route::get('/', [EstrategiasPrevenirController::class, 'index'])->name('estrategiasprevenir.index');
    Route::get('/create', [EstrategiasPrevenirController::class, 'create'])->name('estrategiasprevenir.create');
    Route::post('/', [EstrategiasPrevenirController::class, 'store'])->name('estrategiasprevenir.store');
    Route::get('/{estrategia}', [EstrategiasPrevenirController::class, 'show'])->name('estrategiasprevenir.show');
    Route::get('/{id}/edit', [EstrategiasPrevenirController::class, 'edit'])->name('estrategiasprevenir.edit');
    Route::put('/{estrategia}', [EstrategiasPrevenirController::class, 'update'])->name('estrategiasprevenir.update');
    Route::delete('/{id}', [EstrategiasPrevenirController::class, 'destroy'])->name('estrategiasprevenir.destroy');
});

// Rutas para acciones de prevención bajo una estrategia específica
Route::prefix('{estrategia}/accionprevenir')->group(function () {
    Route::get('/', [AccionPrevenirController::class, 'index'])->name('estrategiasprevenir.accionprevenir.index');
    Route::get('/create', [AccionPrevenirController::class, 'create'])->name('estrategiasprevenir.accionprevenir.create');
    Route::post('/', [AccionPrevenirController::class, 'store'])->name('estrategiasprevenir.accionprevenir.store');
    Route::get('/{accion}', [AccionPrevenirController::class, 'show'])->name('estrategiasprevenir.accionprevenir.show');
    Route::get('/{id}/edit', [AccionPrevenirController::class, 'edit'])->name('estrategiasprevenir.accionprevenir.edit');
    Route::put('/{accion}', [AccionPrevenirController::class, 'update'])->name('estrategiasprevenir.accionprevenir.update');
    Route::delete('/{id}', [AccionPrevenirController::class, 'destroy'])->name('estrategiasprevenir.accionprevenir.destroy');
});
// Ruta para editar una acción de prevención
Route::get('estrategiasprevenir/accionprevenir/{id}/edit', [AccionPrevenirController::class, 'edit'])->name('estrategiasprevenir.accionprevenir.edit');














