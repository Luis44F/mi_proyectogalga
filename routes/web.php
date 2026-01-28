<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PapeletaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlujoProduccionController;
use App\Http\Controllers\ProduccionController;

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
// DASHBOARD
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

    Route::get('/mensajes/fetch/{user}', [MessageController::class, 'fetch'])
        ->name('mensajes.fetch');
});

// --------------------------------------------
// 🧾 PAPELETAS
// --------------------------------------------
Route::middleware('auth')->group(function () {

    // 📄 VER ÚLTIMA PAPELETA
    Route::get('/papeleta', [PapeletaController::class, 'ver'])
        ->name('papeleta.ver');

    // ➕ CREAR PAPELETA
    Route::get('/papeletas/create', [PapeletaController::class, 'create'])
        ->name('papeletas.create');

    Route::post('/papeletas', [PapeletaController::class, 'store'])
        ->name('papeletas.store');

    // ✅ AUTORIZAR
    Route::put('/papeletas/{papeleta}/autorizar', [PapeletaController::class, 'autorizar'])
        ->name('papeletas.autorizar');

    // ⛔ DETENER
    Route::put('/papeletas/{papeleta}/detener', [PapeletaController::class, 'detener'])
        ->name('papeletas.detener');

    // ▶️ REACTIVAR
    Route::put('/papeletas/{papeleta}/reactivar', [PapeletaController::class, 'reactivar'])
        ->name('papeletas.reactivar');

    // 🚀 INICIAR PRODUCCIÓN (CREA LOTES AUTOMÁTICOS)
    Route::post(
        '/papeleta/{id}/iniciar-produccion',
        [PapeletaController::class, 'iniciarProduccion']
    )->name('papeleta.iniciarProduccion');

    // 📦 VER LOTES DE UNA PAPELETA
    Route::get('/papeletas/{papeleta}/lotes', [LoteController::class, 'index'])
        ->name('lotes.index');
});

// --------------------------------------------
// 📦 LOTES (CREAR MANUAL)
// --------------------------------------------
Route::post('/lotes/crear', [LoteController::class, 'store'])
    ->name('lotes.store')
    ->middleware('auth');

// --------------------------------------------
// 🔄 CAMBIAR ESTADO DE LOTE
// --------------------------------------------
Route::middleware('auth')->group(function () {

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

// --------------------------------------------
// FLUJO DE PRODUCCIÓN (POR LOTE)
// --------------------------------------------
Route::middleware('auth')->group(function () {

    Route::post('/flujo-produccion/iniciar', [FlujoProduccionController::class, 'iniciar'])
        ->name('flujo.iniciar');

    Route::post('/flujo-produccion/{id}/finalizar', [FlujoProduccionController::class, 'finalizar'])
        ->name('flujo.finalizar');

    Route::post('/flujo-produccion/{id}/autorizar', [FlujoProduccionController::class, 'autorizar'])
        ->name('flujo.autorizar');

    Route::get('/lotes/{lote}/flujo', [FlujoProduccionController::class, 'index'])
        ->name('flujo.index');

    Route::post('/flujo/{lote}/crear', [FlujoProduccionController::class, 'crearSiguiente'])
        ->name('flujo.crear');

    Route::post('/flujo/{flujo}/check', [FlujoProduccionController::class, 'checkSupervisor'])
        ->name('flujo.check');
});

// --------------------------------------------
// PRODUCCIÓN – FLUJO GENERAL
// --------------------------------------------
Route::middleware('auth')->group(function () {

    Route::get('/produccion/flujo', [ProduccionController::class, 'flujo'])
        ->name('produccion.flujo');
});
