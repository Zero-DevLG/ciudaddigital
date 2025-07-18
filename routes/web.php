<?php

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PrevencionController;
use App\Http\Controllers\TramitesController;

use Livewire\Livewire;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin'])->name('dashboard_admin');

route::get('verificador/dashboard', [HomeController::class, 'verificadorIndex'])->middleware(['auth', 'verificador'])->name('dashboard_verificador');

route::resource('users', UserController::class);

//
route::post('/configuracion/save', [ConfigurationController::class, 'saveConfig'])->name('configuration.save');

// Validar CURP RENAPO

Route::post('/validar-curp', [App\Http\Controllers\CurpController::class, 'validar'])->name('validar.curp');


// Iniciar tramite
Route::get('/tramite/{id}', [App\Http\Controllers\TramitesController::class, 'iniciar'])
    ->name('tramite.iniciar')
    ->middleware('auth');

// Ruta mis tramites
Route::get('/mis-tramites', [App\Http\Controllers\TramitesController::class, 'misTramites'])
    ->name('tramites.usuario')
    ->middleware('auth');

// Retomar tramite

Route::get('/tramites/uso-suelo/{tramite}', [App\Http\Controllers\TramitesController::class, 'mostrarTramite'])->name('tramites.uso_suelo')
    ->middleware('auth');

// Validar tramite
Route::get('/tramites/validar/{tramite}', [App\Http\Controllers\TramitesController::class, 'validarTramite'])->name('tramites.validar')
    ->middleware('auth');

// Generar PDF del tramite
Route::get('/pdf-reporte', [PdfController::class, 'exportar']);


Route::get('/tramite/{id}/pdf', [TramitesController::class, 'generarPdf'])->name('tramite.generar.pdf');


Route::get('/tramites/{id}/resumen', [TramitesController::class, 'mostrarResumen'])->name('tramites.resumen');

Route::get('tramites/{id}/ver', [TramitesController::class, 'verTramite'])->name('tramites.ver');


Route::post('/validaciones/guardar', [PrevencionController::class, 'guardarPrevencion'])->name('validaciones.guardar');

Route::post('/validaciones/obtener', [PrevencionController::class, 'obtenerPrevencion'])->name('validaciones.obtener');
