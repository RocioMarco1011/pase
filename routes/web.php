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
use App\Http\Controllers\EstrategiasAtenderController;
use App\Http\Controllers\AccionAtenderController;
use App\Http\Controllers\EvidenciaAtenderController;
use App\Http\Controllers\IndicadoresAtenderController;
use App\Http\Controllers\CalcularAtenderController;
use App\Http\Controllers\EstrategiasSancionarController;
use App\Http\Controllers\AccionSancionarController;
use App\Http\Controllers\EvidenciaSancionarController;
use App\Http\Controllers\IndicadoresSancionarController;
use App\Http\Controllers\CalcularSancionarController;
use App\Http\Controllers\EstrategiasErradicarController;
use App\Http\Controllers\AccionErradicarController;
use App\Http\Controllers\EvidenciaErradicarController;
use App\Http\Controllers\IndicadoresErradicarController;
use App\Http\Controllers\CalcularErradicarController;

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


// ESTRATEGIAS DE PREVENIR
Route::prefix('estrategiasprevenir')->group(function () {
    Route::get('/', [EstrategiasPrevenirController::class, 'index'])->name('estrategiasprevenir.index');
    Route::get('/create', [EstrategiasPrevenirController::class, 'create'])->name('estrategiasprevenir.create');
    Route::post('/', [EstrategiasPrevenirController::class, 'store'])->name('estrategiasprevenir.store');
    Route::get('/{estrategia}', [EstrategiasPrevenirController::class, 'show'])->name('estrategiasprevenir.show');
    Route::get('/{id}/edit', [EstrategiasPrevenirController::class, 'edit'])->name('estrategiasprevenir.edit');
    Route::put('/{estrategia}', [EstrategiasPrevenirController::class, 'update'])->name('estrategiasprevenir.update');
    Route::delete('/{id}', [EstrategiasPrevenirController::class, 'destroy'])->name('estrategiasprevenir.destroy');
});

// ACCIONES DE PREVENIR
Route::prefix('{estrategia}/accionprevenir')->group(function () {
    Route::get('/', [AccionPrevenirController::class, 'index'])->name('estrategiasprevenir.accionprevenir.index');
    Route::get('/create', [AccionPrevenirController::class, 'create'])->name('estrategiasprevenir.accionprevenir.create');
    Route::post('/', [AccionPrevenirController::class, 'store'])->name('estrategiasprevenir.accionprevenir.store');
    Route::get('/{accion}', [AccionPrevenirController::class, 'show'])->name('estrategiasprevenir.accionprevenir.show');
    Route::delete('/{id}', [AccionPrevenirController::class, 'destroy'])->name('estrategiasprevenir.accionprevenir.destroy');
});

// ACCION PREVENIR EDIT
Route::get('estrategiasprevenir/{estrategiaId}/accionprevenir/{accionPrevenirId}/edit', [AccionPrevenirController::class, 'edit'])
    ->name('estrategiasprevenir.accionprevenir.edit');

// ACCION PREVENIR UPDATE
Route::put('estrategiasprevenir/{estrategiaId}/accionprevenir/{accionPrevenirId}', [AccionPrevenirController::class, 'update'])
    ->name('estrategiasprevenir.accionprevenir.update');

// EVIDENCIAS PREVENIR
Route::prefix('/estrategias/{estrategiaId}/acciones/{accionPrevenirId}')->group(function () {
    Route::get('/evidencias/prevenir', [EvidenciaPrevenirController::class, 'index'])->name('evidenciaprevenir.index');
    Route::get('/evidencias/prevenir/create', [EvidenciaPrevenirController::class, 'create'])->name('evidenciaprevenir.create');
    Route::post('/evidencias/prevenir', [EvidenciaPrevenirController::class, 'store'])->name('evidenciaprevenir.store');
    Route::get('/evidencias/prevenir/{evidenciaId}/edit', [EvidenciaPrevenirController::class, 'edit'])->name('evidenciaprevenir.edit');
    Route::put('/evidencias/prevenir/{evidenciaId}', [EvidenciaPrevenirController::class, 'update'])->name('evidenciaprevenir.update');
    Route::delete('/evidencias/prevenir/{evidenciaId}', [EvidenciaPrevenirController::class, 'destroy'])->name('evidenciaprevenir.destroy');
});

// EVIDENCIAS FILE
Route::get('/download/{filename}', [ArchivoController::class, 'download'])->name('file.download');

// INDICADORES PREVENIR
Route::prefix('indicadoresprevenir')->group(function () {
    Route::get('/', [IndicadoresPrevenirController::class, 'index'])->name('indicadoresprevenir.index');
    Route::get('/create', [IndicadoresPrevenirController::class, 'create'])->name('indicadoresprevenir.create');
    Route::post('/', [IndicadoresPrevenirController::class, 'store'])->name('indicadoresprevenir.store');
    Route::get('/{indicadorprevenir}', [IndicadoresPrevenirController::class, 'show'])->name('indicadoresprevenir.show');
    Route::get('/{id}/edit', [IndicadoresPrevenirController::class, 'edit'])->name('indicadoresprevenir.edit');
    Route::put('/{indicadorprevenir}', [IndicadoresPrevenirController::class, 'update'])->name('indicadoresprevenir.update');
    Route::delete('/{id}', [IndicadoresPrevenirController::class, 'destroy'])->name('indicadoresprevenir.destroy');
});

// CALCULAR PREVENIR
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

// CALCULAR PREVENIR PDF
Route::get('/descargar-pdf/prevenir/{indicadorprevenir}', [CalcularPrevenirController::class, 'descargarPDF'])->name('descargar.pdf.prevenir');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ESTRATEGIAS DE ATENDER
Route::prefix('estrategiasatender')->group(function () {
    Route::get('/', [EstrategiasAtenderController::class, 'index'])->name('estrategiasatender.index');
    Route::get('/create', [EstrategiasAtenderController::class, 'create'])->name('estrategiasatender.create');
    Route::post('/', [EstrategiasAtenderController::class, 'store'])->name('estrategiasatender.store');
    Route::get('/{estrategia}', [EstrategiasAtenderController::class, 'show'])->name('estrategiasatender.show');
    Route::get('/{id}/edit', [EstrategiasAtenderController::class, 'edit'])->name('estrategiasatender.edit');
    Route::put('/{estrategia}', [EstrategiasAtenderController::class, 'update'])->name('estrategiasatender.update');
    Route::delete('/{id}', [EstrategiasAtenderController::class, 'destroy'])->name('estrategiasatender.destroy');
});

// ACCIONES DE ATENDER
Route::prefix('{estrategia}/accionatender')->group(function () {
    Route::get('/', [AccionAtenderController::class, 'index'])->name('estrategiasatender.accionatender.index');
    Route::get('/create', [AccionAtenderController::class, 'create'])->name('estrategiasatender.accionatender.create');
    Route::post('/', [AccionAtenderController::class, 'store'])->name('estrategiasatender.accionatender.store');
    Route::get('/{accion}', [AccionAtenderController::class, 'show'])->name('estrategiasatender.accionatender.show');
    Route::delete('/{id}', [AccionAtenderController::class, 'destroy'])->name('estrategiasatender.accionatender.destroy');
});

// ACCION ATENDER EDIT
Route::get('estrategiasatender/{estrategiaId}/accionatender/{accionAtenderId}/edit', [AccionAtenderController::class, 'edit'])
    ->name('estrategiasatender.accionatender.edit');

// ACCION ATENDER UPDATE
Route::put('estrategiasatender/{estrategiaId}/accionatender/{accionAtenderId}', [AccionAtenderController::class, 'update'])
    ->name('estrategiasatender.accionatender.update');

// EVIDENCIAS ATENDER
Route::prefix('/estrategias/{estrategiaId}/acciones/{accionAtenderId}')->group(function () {
    Route::get('/evidencias/atender', [EvidenciaAtenderController::class, 'index'])->name('evidenciaatender.index');
    Route::get('/evidencias/atender/create', [EvidenciaAtenderController::class, 'create'])->name('evidenciaatender.create');
    Route::post('/evidencias/atender', [EvidenciaAtenderController::class, 'store'])->name('evidenciaatender.store');
    Route::get('/evidencias/atender/{evidenciaId}/edit', [EvidenciaAtenderController::class, 'edit'])->name('evidenciaatender.edit');
    Route::put('/evidencias/atender/{evidenciaId}', [EvidenciaAtenderController::class, 'update'])->name('evidenciaatender.update');
    Route::delete('/evidencias/atender/{evidenciaId}', [EvidenciaAtenderController::class, 'destroy'])->name('evidenciaatender.destroy');
});

// EVIDENCIAS FILE
Route::get('/download/{filename}', [ArchivoController::class, 'download'])->name('file.download');

// INDICADORES ATENDER
Route::prefix('indicadoresatender')->group(function () {
    Route::get('/', [IndicadoresAtenderController::class, 'index'])->name('indicadoresatender.index');
    Route::get('/create', [IndicadoresAtenderController::class, 'create'])->name('indicadoresatender.create');
    Route::post('/', [IndicadoresAtenderController::class, 'store'])->name('indicadoresatender.store');
    Route::get('/{indicadoratender}', [IndicadoresAtenderController::class, 'show'])->name('indicadoresatender.show');
    Route::get('/{id}/edit', [IndicadoresAtenderController::class, 'edit'])->name('indicadoresatender.edit');
    Route::put('/{indicadoratender}', [IndicadoresAtenderController::class, 'update'])->name('indicadoresatender.update');
    Route::delete('/{id}', [IndicadoresAtenderController::class, 'destroy'])->name('indicadoresatender.destroy');
});

// CALCULAR ATENDER
Route::get('/{indicadoratender}/calcularatender', [CalcularAtenderController::class, 'index'])
    ->name('indicadoresatender.calcularatender.index');
Route::post('/indicadoresatender/{indicadoratender}/calcularatender/guardarformula', [CalcularAtenderController::class, 'guardarFormula'])
    ->name('indicadoresatender.calcularatender.guardarFormula');
Route::get('/indicadoresatender/calcularatender/calculos/{indicadoratender}', [CalcularAtenderController::class, 'mostrarCalculo'])
    ->name('indicadoresatender.calcularatender.calculos');
Route::get('/indicadoresatender/{indicadoratender}/calcular', [CalcularAtenderController::class, 'calcularNuevo'])
    ->name('indicadoresatender.calcularatender.calcular');
Route::post('/indicadoresatender/{indicadoratender}/guardar-nuevo-calculo', [CalcularAtenderController::class, 'guardarNuevoCalculo'])
    ->name('indicadoresatender.calcularatender.guardarNuevoCalculo');
Route::get('indicadoresatender/calcularatender/show/{id}', [CalcularAtenderController::class, 'show'])
    ->name('indicadoresatender.calcularatender.show');
Route::get('/indicadoresatender/calcularatender/{calculo}/edit', [CalcularAtenderController::class, 'edit'])
    ->name('indicadoresatender.calcularatender.edit');
Route::put('/indicadoresatender/calcularatender/{calculo}', [CalcularAtenderController::class, 'update'])
    ->name('indicadoresatender.calcularatender.update');
Route::delete('/indicadoresatender/calcularatender/{calculo}', [CalcularAtenderController::class, 'destroy'])
    ->name('indicadoresatender.calcularatender.destroy');

// CALCULAR ATENDER PDF
Route::get('/descargar-pdf/atender/{indicadoratender}', [CalcularAtenderController::class, 'descargarPDF'])->name('descargar.pdf.atender');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ESTRATEGIAS DE SANCIONAR
Route::prefix('estrategiassancionar')->group(function () {
    Route::get('/', [EstrategiasSancionarController::class, 'index'])->name('estrategiassancionar.index');
    Route::get('/create', [EstrategiasSancionarController::class, 'create'])->name('estrategiassancionar.create');
    Route::post('/', [EstrategiasSancionarController::class, 'store'])->name('estrategiassancionar.store');
    Route::get('/{estrategia}', [EstrategiasSancionarController::class, 'show'])->name('estrategiassancionar.show');
    Route::get('/{id}/edit', [EstrategiasSancionarController::class, 'edit'])->name('estrategiassancionar.edit');
    Route::put('/{estrategia}', [EstrategiasSancionarController::class, 'update'])->name('estrategiassancionar.update');
    Route::delete('/{id}', [EstrategiasSancionarController::class, 'destroy'])->name('estrategiassancionar.destroy');
});

// ACCIONES DE SANCIONAR
Route::prefix('{estrategia}/accionsancionar')->group(function () {
    Route::get('/', [AccionSancionarController::class, 'index'])->name('estrategiassancionar.accionsancionar.index');
    Route::get('/create', [AccionSancionarController::class, 'create'])->name('estrategiassancionar.accionsancionar.create');
    Route::post('/', [AccionSancionarController::class, 'store'])->name('estrategiassancionar.accionsancionar.store');
    Route::get('/{accion}', [AccionSancionarController::class, 'show'])->name('estrategiassancionar.accionsancionar.show');
    Route::delete('/{id}', [AccionSancionarController::class, 'destroy'])->name('estrategiassancionar.accionsancionar.destroy');
});

// ACCION SANCIONAR EDIT
Route::get('estrategiassancionar/{estrategiaId}/accionsancionar/{accionSancionarId}/edit', [AccionSancionarController::class, 'edit'])
    ->name('estrategiassancionar.accionsancionar.edit');

// ACCION SANCIONAR UPDATE
Route::put('estrategiassancionar/{estrategiaId}/accionsancionar/{accionSancionarId}', [AccionSancionarController::class, 'update'])
    ->name('estrategiassancionar.accionsancionar.update');

// EVIDENCIAS SANCIONAR
Route::prefix('/estrategias/{estrategiaId}/acciones/{accionSancionarId}')->group(function () {
    Route::get('/evidencias/sancionar', [EvidenciaSancionarController::class, 'index'])->name('evidenciasancionar.index');
    Route::get('/evidencias/sancionar/create', [EvidenciaSancionarController::class, 'create'])->name('evidenciasancionar.create');
    Route::post('/evidencias/sancionar', [EvidenciaSancionarController::class, 'store'])->name('evidenciasancionar.store');
    Route::get('/evidencias/sancionar/{evidenciaId}/edit', [EvidenciaSancionarController::class, 'edit'])->name('evidenciasancionar.edit');
    Route::put('/evidencias/sancionar/{evidenciaId}', [EvidenciaSancionarController::class, 'update'])->name('evidenciasancionar.update');
    Route::delete('/evidencias/sancionar/{evidenciaId}', [EvidenciaSancionarController::class, 'destroy'])->name('evidenciasancionar.destroy');
});

// EVIDENCIAS FILE
Route::get('/download/{filename}', [ArchivoController::class, 'download'])->name('file.download');

// INDICADORES SANCIONAR
Route::prefix('indicadoressancionar')->group(function () {
    Route::get('/', [IndicadoresSancionarController::class, 'index'])->name('indicadoressancionar.index');
    Route::get('/create', [IndicadoresSancionarController::class, 'create'])->name('indicadoressancionar.create');
    Route::post('/', [IndicadoresSancionarController::class, 'store'])->name('indicadoressancionar.store');
    Route::get('/{indicadorsancionar}', [IndicadoresSancionarController::class, 'show'])->name('indicadoressancionar.show');
    Route::get('/{id}/edit', [IndicadoresSancionarController::class, 'edit'])->name('indicadoressancionar.edit');
    Route::put('/{indicadorsancionar}', [IndicadoresSancionarController::class, 'update'])->name('indicadoressancionar.update');
    Route::delete('/{id}', [IndicadoresSancionarController::class, 'destroy'])->name('indicadoressancionar.destroy');
});

// CALCULAR SANCIONAR
Route::get('/{indicadorsancionar}/calcularsancionar', [CalcularSancionarController::class, 'index'])
    ->name('indicadoressancionar.calcularsancionar.index');
Route::post('/indicadoressancionar/{indicadorsancionar}/calcularsancionar/guardarformula', [CalcularSancionarController::class, 'guardarFormula'])
    ->name('indicadoressancionar.calcularsancionar.guardarFormula');
Route::get('/indicadoressancionar/calcularsancionar/calculos/{indicadorsancionar}', [CalcularSancionarController::class, 'mostrarCalculo'])
    ->name('indicadoressancionar.calcularsancionar.calculos');
Route::get('/indicadoressancionar/{indicadorsancionar}/calcular', [CalcularSancionarController::class, 'calcularNuevo'])
    ->name('indicadoressancionar.calcularsancionar.calcular');
Route::post('/indicadoressancionar/{indicadorsancionar}/guardar-nuevo-calculo', [CalcularSancionarController::class, 'guardarNuevoCalculo'])
    ->name('indicadoressancionar.calcularsancionar.guardarNuevoCalculo');
Route::get('indicadoressancionar/calcularsancionar/show/{id}', [CalcularSancionarController::class, 'show'])
    ->name('indicadoressancionar.calcularsancionar.show');
Route::get('/indicadoressancionar/calcularsancionar/{calculo}/edit', [CalcularSancionarController::class, 'edit'])
    ->name('indicadoressancionar.calcularsancionar.edit');
Route::put('/indicadoressancionar/calcularsancionar/{calculo}', [CalcularSancionarController::class, 'update'])
    ->name('indicadoressancionar.calcularsancionar.update');
Route::delete('/indicadoressancionar/calcularsancionar/{calculo}', [CalcularSancionarController::class, 'destroy'])
    ->name('indicadoressancionar.calcularsancionar.destroy');

// CALCULAR SANCIONAR PDF
Route::get('/descargar-pdf/sancionar/{indicadorsancionar}', [CalcularSancionarController::class, 'descargarPDF'])->name('descargar.pdf.sancionar');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ESTRATEGIAS DE ERRADICAR
Route::prefix('estrategiaserradicar')->group(function () {
    Route::get('/', [EstrategiasErradicarController::class, 'index'])->name('estrategiaserradicar.index');
    Route::get('/create', [EstrategiasErradicarController::class, 'create'])->name('estrategiaserradicar.create');
    Route::post('/', [EstrategiasErradicarController::class, 'store'])->name('estrategiaserradicar.store');
    Route::get('/{estrategia}', [EstrategiasErradicarController::class, 'show'])->name('estrategiaserradicar.show');
    Route::get('/{id}/edit', [EstrategiasErradicarController::class, 'edit'])->name('estrategiaserradicar.edit');
    Route::put('/{estrategia}', [EstrategiasErradicarController::class, 'update'])->name('estrategiaserradicar.update');
    Route::delete('/{id}', [EstrategiasErradicarController::class, 'destroy'])->name('estrategiaserradicar.destroy');
});

// ACCIONES DE ERRADICAR
Route::prefix('{estrategia}/accionerradicar')->group(function () {
    Route::get('/', [AccionErradicarController::class, 'index'])->name('estrategiaserradicar.accionerradicar.index');
    Route::get('/create', [AccionErradicarController::class, 'create'])->name('estrategiaserradicar.accionerradicar.create');
    Route::post('/', [AccionErradicarController::class, 'store'])->name('estrategiaserradicar.accionerradicar.store');
    Route::get('/{accion}', [AccionErradicarController::class, 'show'])->name('estrategiaserradicar.accionerradicar.show');
    Route::delete('/{id}', [AccionErradicarController::class, 'destroy'])->name('estrategiaserradicar.accionerradicar.destroy');
});

// ACCION ERRADICAR EDIT
Route::get('estrategiaserradicar/{estrategiaId}/accionerradicar/{accionErradicarId}/edit', [AccionErradicarController::class, 'edit'])
    ->name('estrategiaserradicar.accionerradicar.edit');

// ACCION ERRADICAR UPDATE
Route::put('estrategiaserradicar/{estrategiaId}/accionerradicar/{accionErradicarId}', [AccionErradicarController::class, 'update'])
    ->name('estrategiaserradicar.accionerradicar.update');

// EVIDENCIAS ERRADICAR
Route::prefix('/estrategias/{estrategiaId}/acciones/{accionErradicarId}')->group(function () {
    Route::get('/evidencias/erradicar', [EvidenciaErradicarController::class, 'index'])->name('evidenciaerradicar.index');
    Route::get('/evidencias/erradicar/create', [EvidenciaErradicarController::class, 'create'])->name('evidenciaerradicar.create');
    Route::post('/evidencias/erradicar', [EvidenciaErradicarController::class, 'store'])->name('evidenciaerradicar.store');
    Route::get('/evidencias/erradicar/{evidenciaId}/edit', [EvidenciaErradicarController::class, 'edit'])->name('evidenciaerradicar.edit');
    Route::put('/evidencias/erradicar/{evidenciaId}', [EvidenciaErradicarController::class, 'update'])->name('evidenciaerradicar.update');
    Route::delete('/evidencias/erradicar/{evidenciaId}', [EvidenciaErradicarController::class, 'destroy'])->name('evidenciaerradicar.destroy');
});

// EVIDENCIAS FILE
Route::get('/download/{filename}', [ArchivoController::class, 'download'])->name('file.download');

// INDICADORES ERRADICAR
Route::prefix('indicadoreserradicar')->group(function () {
    Route::get('/', [IndicadoresErradicarController::class, 'index'])->name('indicadoreserradicar.index');
    Route::get('/create', [IndicadoresErradicarController::class, 'create'])->name('indicadoreserradicar.create');
    Route::post('/', [IndicadoresErradicarController::class, 'store'])->name('indicadoreserradicar.store');
    Route::get('/{indicadorerradicar}', [IndicadoresErradicarController::class, 'show'])->name('indicadoreserradicar.show');
    Route::get('/{id}/edit', [IndicadoresErradicarController::class, 'edit'])->name('indicadoreserradicar.edit');
    Route::put('/{indicadorerradicar}', [IndicadoresErradicarController::class, 'update'])->name('indicadoreserradicar.update');
    Route::delete('/{id}', [IndicadoresErradicarController::class, 'destroy'])->name('indicadoreserradicar.destroy');
});

// CALCULAR ERRADICAR
Route::get('/{indicadorerradicar}/calcularerradicar', [CalcularErradicarController::class, 'index'])
    ->name('indicadoreserradicar.calcularerradicar.index');
Route::post('/indicadoreserradicar/{indicadorerradicar}/calcularerradicar/guardarformula', [CalcularErradicarController::class, 'guardarFormula'])
    ->name('indicadoreserradicar.calcularerradicar.guardarFormula');
Route::get('/indicadoreserradicar/calcularerradicar/calculos/{indicadorerradicar}', [CalcularErradicarController::class, 'mostrarCalculo'])
    ->name('indicadoreserradicar.calcularerradicar.calculos');
Route::get('/indicadoreserradicar/{indicadorerradicar}/calcular', [CalcularErradicarController::class, 'calcularNuevo'])
    ->name('indicadoreserradicar.calcularerradicar.calcular');
Route::post('/indicadoreserradicar/{indicadorerradicar}/guardar-nuevo-calculo', [CalcularErradicarController::class, 'guardarNuevoCalculo'])
    ->name('indicadoreserradicar.calcularerradicar.guardarNuevoCalculo');
Route::get('indicadoreserradicar/calcularerradicar/show/{id}', [CalcularErradicarController::class, 'show'])
    ->name('indicadoreserradicar.calcularerradicar.show');
Route::get('/indicadoreserradicar/calcularerradicar/{calculo}/edit', [CalcularErradicarController::class, 'edit'])
    ->name('indicadoreserradicar.calcularerradicar.edit');
Route::put('/indicadoreserradicar/calcularerradicar/{calculo}', [CalcularErradicarController::class, 'update'])
    ->name('indicadoreserradicar.calcularerradicar.update');
Route::delete('/indicadoreserradicar/calcularerradicar/{calculo}', [CalcularErradicarController::class, 'destroy'])
    ->name('indicadoreserradicar.calcularerradicar.destroy');

// CALCULAR ERRADICAR PDF
Route::get('/descargar-pdf/erradicar/{indicadorerradicar}', [CalcularErradicarController::class, 'descargarPDF'])->name('descargar.pdf.erradicar');



















