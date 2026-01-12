<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PapeletaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

// --------------------------------------------
// HOME
// --------------------------------------------
Route::get('/', function () {
    return view('index');
})->name('home');

// --------------------------------------------
// LOGIN
// --------------------------------------------
Route::get('/login', function () {
    return view('inicio_sesion');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

// --------------------------------------------
// REGISTRO
// --------------------------------------------
Route::get('/crear_cuenta', function () {
    return view('crear_cuenta');
})->name('crear.cuenta');

Route::post('/crear-cuenta', [AuthController::class, 'registrar'])
    ->name('registrar');

// --------------------------------------------
// DASHBOARD (CORRECTO)
// --------------------------------------------
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// --------------------------------------------
// MENSAJES
// --------------------------------------------
Route::middleware('auth')->group(function () {

    Route::post('/mensajes', [MessageController::class, 'store'])
        ->name('mensajes.store');

    Route::get('/mensajes/leido/{id}', [MessageController::class, 'markAsRead'])
        ->name('mensajes.read');
});

// --------------------------------------------
// PAPELETAS
// --------------------------------------------
Route::middleware('auth')->group(function () {

    Route::get('/papeletas', [PapeletaController::class, 'index'])
        ->name('papeletas.index');

    Route::post('/papeletas', [PapeletaController::class, 'store'])
        ->name('papeletas.store');

    Route::get('/papeletas/{id}/lotes', [LoteController::class, 'index'])
        ->name('lotes.index');
});

// --------------------------------------------
// LOTES / PRODUCCIÓN
// --------------------------------------------
Route::middleware('auth')->group(function () {

    Route::post('/lotes', [LoteController::class, 'store'])
        ->name('lotes.store');

    Route::get('/lotes/{lote}/estado/{estado}', [LoteController::class, 'cambiarEstado'])
        ->name('lotes.estado');
});

// --------------------------------------------
// ADMIN – CAMBIAR ROL
// --------------------------------------------
Route::middleware('auth')->group(function () {

    Route::post('/admin/usuarios/{user}/rol', [AdminController::class, 'cambiarRol'])
        ->name('admin.usuario.rol');
});
