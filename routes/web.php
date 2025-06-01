<?php

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

route::resource('users', UserController::class);

//
route::post('/configuracion/save', [ConfigurationController::class, 'saveConfig'])->name('configuration.save');

// Validar CURP RENAPO

Route::post('/validar-curp', [App\Http\Controllers\CurpController::class, 'validar'])->name('validar.curp');


// Cargar tramite
Route::get('/tramite/{tramite}', function ($tramite) {
    return view('tramite.iniciar', ['tramite' => $tramite]);
})->name('tramite.iniciar')->middleware('auth');
