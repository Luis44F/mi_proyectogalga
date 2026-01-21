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

    // 🔄 Mensajes en tiempo real
    Route::get('/mensajes/fetch/{user}', [MessageController::class, 'fetch'])
        ->name('mensajes.fetch');
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

// --------------------------------------------
// PAPELETAS – ACCIONES ADMIN
// --------------------------------------------
Route::middleware('auth')->group(function () {

    Route::post('/papeletas/{id}/autorizar', [PapeletaController::class, 'autorizar'])
        ->name('papeletas.autorizar');

    Route::post('/papeletas/{id}/detener', [PapeletaController::class, 'detener'])
        ->name('papeletas.detener');

    Route::post('/papeletas/{id}/reactivar', [PapeletaController::class, 'reactivar'])
        ->name('papeletas.reactivar');
});

// --------------------------------------------
// FLUJO DE PRODUCCIÓN (COMPLETO)
// --------------------------------------------
Route::middleware('auth')->group(function () {

    // ▶ Iniciar etapa
    Route::post('/flujo-produccion/iniciar',
        [FlujoProduccionController::class, 'iniciar']
    )->name('flujo.iniciar');

    // ⏹ Finalizar etapa
    Route::post('/flujo-produccion/{id}/finalizar',
        [FlujoProduccionController::class, 'finalizar']
    )->name('flujo.finalizar');

    // 🔐 Autorizar etapa (Administrador)
    Route::post('/flujo-produccion/{id}/autorizar',
        [FlujoProduccionController::class, 'autorizar']
    )->name('flujo.autorizar');

    // 📊 Ver flujo completo por lote
    Route::get('/lotes/{lote}/flujo',
        [FlujoProduccionController::class, 'index']
    )->name('flujo.index');

    // ➕ Crear siguiente etapa del flujo
    Route::post('/flujo/{lote}/crear',
        [FlujoProduccionController::class, 'crearSiguiente']
    )->name('flujo.crear');

    // ✅ Check de supervisor
    Route::post('/flujo/{flujo}/check',
        [FlujoProduccionController::class, 'checkSupervisor']
    )->name('flujo.check');
});


// --------------------------------------------
// PRODUCCIÓN – FLUJO GENERAL (AISLADO)
// --------------------------------------------
Route::middleware('auth')->group(function () {

    Route::get('/produccion/flujo', 
        [ProduccionController::class, 'flujo']
    )->name('produccion.flujo');

});
