<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrevenirController;
use App\Http\Controllers\EstrategiasPrevenirController;
use App\Http\Controllers\AccionPrevenirController;
use App\Http\Controllers\EvidenciaPrevenirController;
use App\Http\Controllers\ArchivoController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\IndicadoresPrevenirController;
use App\Http\Controllers\CalcularPrevenirController;
use App\Models\IndicadorPrevenir;
use App\Http\Controllers\EstrategiasAtenderController;
use App\Http\Controllers\AccionAtenderController;


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
    Route::delete('/{id}', [AccionPrevenirController::class, 'destroy'])->name('estrategiasprevenir.accionprevenir.destroy');
});

// Ruta para mostrar el formulario de edición
Route::get('estrategiasprevenir/{estrategiaId}/accionprevenir/{accionPrevenirId}/edit', [AccionPrevenirController::class, 'edit'])
    ->name('estrategiasprevenir.accionprevenir.edit');

// Ruta para procesar la actualización
Route::put('estrategiasprevenir/{estrategiaId}/accionprevenir/{accionPrevenirId}', [AccionPrevenirController::class, 'update'])
    ->name('estrategiasprevenir.accionprevenir.update');

    //Rutas para evidencias de prevencion bajo una accion especifica dentro de una estrategia especifica
Route::prefix('/estrategias/{estrategiaId}/acciones/{accionPrevenirId}')->group(function () {
    Route::get('/evidencias', [EvidenciaPrevenirController::class, 'index'])->name('evidenciaprevenir.index');
    Route::get('/evidencias/create', [EvidenciaPrevenirController::class, 'create'])->name('evidenciaprevenir.create');
    Route::post('/evidencias', [EvidenciaPrevenirController::class, 'store'])->name('evidenciaprevenir.store');
    Route::get('/evidencias/{evidenciaId}/edit', [EvidenciaPrevenirController::class, 'edit'])->name('evidenciaprevenir.edit');
    Route::put('/evidencias/{evidenciaId}', [EvidenciaPrevenirController::class, 'update'])->name('evidenciaprevenir.update');
    Route::delete('/evidencias/{evidenciaId}', [EvidenciaPrevenirController::class, 'destroy'])->name('evidenciaprevenir.destroy');
});

//Ruta de la descarga del archivo
Route::get('/download/{filename}', [ArchivoController::class, 'download'])->name('file.download');

//Rutas para los indicadores de prevencion
Route::prefix('indicadoresprevenir')->group(function () {
    Route::get('/', [IndicadoresPrevenirController::class, 'index'])->name('indicadoresprevenir.index');
    Route::get('/create', [IndicadoresPrevenirController::class, 'create'])->name('indicadoresprevenir.create');
    Route::post('/', [IndicadoresPrevenirController::class, 'store'])->name('indicadoresprevenir.store');
    Route::get('/{indicadorprevenir}', [IndicadoresPrevenirController::class, 'show'])->name('indicadoresprevenir.show');
    Route::get('/{id}/edit', [IndicadoresPrevenirController::class, 'edit'])->name('indicadoresprevenir.edit');
    Route::put('/{indicadorprevenir}', [IndicadoresPrevenirController::class, 'update'])->name('indicadoresprevenir.update');
    Route::delete('/{id}', [IndicadoresPrevenirController::class, 'destroy'])->name('indicadoresprevenir.destroy');
});

//Rutas para la formula de los indicadores de prevencion 
    Route::get('/{indicadorprevenir}/calcularprevenir', [CalcularPrevenirController::class, 'index'])
    ->name('indicadoresprevenir.calcularprevenir.index');
    Route::post('/indicadoresprevenir/{indicadorprevenir}/calcularprevenir/guardarformula', [CalcularPrevenirController::class, 'guardarFormula'])
    ->name('indicadoresprevenir.calcularprevenir.guardarFormula');
    Route::get('/indicadoresprevenir/calcularprevenir/calculos/{indicadorprevenir}', [CalcularPrevenirController::class, 'mostrarCalculo'])
    ->name('indicadoresprevenir.calcularprevenir.calculos');
    Route::get('/indicadoresprevenir/{indicadorprevenir}/calcular', [CalcularPrevenirController::class, 'calcularNuevo'])
    ->name('indicadoresprevenir.calcularprevenir.calcular');
    Route::post('/indicadoresprevenir/{indicadorprevenir}/guardar-nuevo-calculo', [CalcularPrevenirController::class, 'guardarNuevoCalculo'])
    ->name('indicadoresprevenir.calcularprevenir.guardarNuevoCalculo');
    Route::get('indicadoresprevenir/calcularprevenir/show/{id}', [CalcularPrevenirController::class, 'show'])
    ->name('indicadoresprevenir.calcularprevenir.show');
    Route::get('/indicadoresprevenir/calcularprevenir/{calculo}/edit', [CalcularPrevenirController::class, 'edit'])
    ->name('indicadoresprevenir.calcularprevenir.edit');
    Route::put('/indicadoresprevenir/calcularprevenir/{calculo}', [CalcularPrevenirController::class, 'update'])
    ->name('indicadoresprevenir.calcularprevenir.update');
    Route::delete('/indicadoresprevenir/calcularprevenir/{calculo}', [CalcularPrevenirController::class, 'destroy'])
    ->name('indicadoresprevenir.calcularprevenir.destroy');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Rutas para las estrategias de atención
Route::prefix('estrategiasatender')->group(function () {
    Route::get('/', [EstrategiasAtenderController::class, 'index'])->name('estrategiasatender.index');
    Route::get('/create', [EstrategiasAtenderController::class, 'create'])->name('estrategiasatender.create');
    Route::post('/', [EstrategiasAtenderController::class, 'store'])->name('estrategiasatender.store');
    Route::get('/{estrategia}', [EstrategiasAtenderController::class, 'show'])->name('estrategiasatender.show');
    Route::get('/{id}/edit', [EstrategiasAtenderController::class, 'edit'])->name('estrategiasatender.edit');
    Route::put('/{estrategia}', [EstrategiasAtenderController::class, 'update'])->name('estrategiasatender.update');
    Route::delete('/{id}', [EstrategiasAtenderController::class, 'destroy'])->name('estrategiasatender.destroy');
});

// Rutas para acciones de atención bajo una estrategia específica
Route::prefix('{estrategia}/accionatender')->group(function () {
    Route::get('/', [AccionAtenderController::class, 'index'])->name('estrategiasatender.accionatender.index');
    Route::get('/create', [AccionAtenderController::class, 'create'])->name('estrategiasatender.accionatender.create');
    Route::post('/', [AccionAtenderController::class, 'store'])->name('estrategiasatender.accionatender.store');
    Route::get('/{accion}', [AccionAtenderController::class, 'show'])->name('estrategiasatender.accionatender.show');
    Route::delete('/{id}', [AccionAtenderController::class, 'destroy'])->name('estrategiasatender.accionatender.destroy');
});

// Ruta para mostrar el formulario de edición
Route::get('estrategiasatender/{estrategiaId}/accionatender/{accionAtenderId}/edit', [AccionAtenderController::class, 'edit'])
    ->name('estrategiasatender.accionatender.edit');

// Ruta para procesar la actualización
Route::put('estrategiasatender/{estrategiaId}/accionatender/{accionAtenderId}', [AccionAtenderController::class, 'update'])
    ->name('estrategiasatender.accionatender.update');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


































