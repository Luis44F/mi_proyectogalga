<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PapeletaController;
use App\Http\Controllers\LoteController;

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
// DASHBOARD (MENSAJERÍA INTEGRADA)
// --------------------------------------------
// Aquí se muestra:
// - Métricas (aún no funcionales)
// - Lista de usuarios
// - Conversación por usuario (?user=ID)
// - Chat tipo WhatsApp
Route::get('/dashboard', [MessageController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


// --------------------------------------------
// MENSAJES (ACCIONES)
// --------------------------------------------
Route::middleware('auth')->group(function () {

    // Enviar mensaje
    Route::post('/mensajes', [MessageController::class, 'store'])
        ->name('mensajes.store');

    // Marcar mensaje como leído
    Route::get('/mensajes/leido/{id}', [MessageController::class, 'markAsRead'])
        ->name('mensajes.read');
});


// --------------------------------------------
// PAPELETAS
// --------------------------------------------
Route::middleware('auth')->group(function () {

    // Ver listado + formulario de papeletas
    Route::get('/papeletas', [PapeletaController::class, 'index'])
        ->name('papeletas.index');

    // Guardar papeleta
    Route::post('/papeletas', [PapeletaController::class, 'store'])
        ->name('papeletas.store');
});




Route::middleware('auth')->group(function () {

    Route::get('/papeletas/{id}/lotes', [LoteController::class, 'index'])
        ->name('lotes.index');

    Route::post('/lotes', [LoteController::class, 'store'])
        ->name('lotes.store');
});