<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\ObraDetalleController;
use App\Http\Controllers\ObraCamaraController;
use App\Http\Controllers\ObraPlanoController;
use App\Http\Controllers\ObraContratoController;
use App\Http\Controllers\ObraFotoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\NewRegisterController;
use App\Http\Controllers\ObraPersonaController;
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

Route::redirect('/', '/login');  

// Route::get('/new-register', function () {
//     return view('auth.new-register');
// })->name('new-register');
// routes/web.php
Route::get('/new-register', [NewRegisterController::class, 'showForm'])->name('new-register');
Route::post('/new-register', [NewRegisterController::class, 'store'])->name('new-register.store');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');




// Route::middleware(['auth'])->group(function () {
Route::middleware(['auth', 'verified', 'profile.complete'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

    // Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
    Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])
    ->middleware('can:view,cliente')
    ->name('clientes.show');


    Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    Route::get('/clientes/{cliente}/obras', [ClienteController::class, 'obras'])->name('clientes.obras');
    Route::post('/clientes/{cliente}/invitaciones', [ClienteController::class, 'storeInvitation'])
        ->name('clientes.invitaciones.store');
    });


Route::middleware(['auth','verified', 'profile.complete'])->group(function () {
    
    // Dashboard de obras
    Route::get('/works/dashboard', [ObraController::class, 'dashboard'])->name('works.dashboard');
    
    // Búsqueda de obras
    Route::get('/works/search', [ObraController::class, 'search'])->name('works.search');
    
    // Rutas resourceful completas para obras
    Route::resource('works', ObraController::class)->names([
        'index' => 'works.index',
        'create' => 'works.create',
        'store' => 'works.store',
        'show' => 'works.show',
        'edit' => 'works.edit',
        'update' => 'works.update',
        'destroy' => 'works.destroy',
    ])->parameters([
        'works' => 'obra'
    ]);
// Rutas para Fotos
Route::middleware(['auth'])->group(function () {
    Route::prefix('obras/{obra}/fotos')->name('obras.fotos.')->group(function () {
        Route::post('/', [ObraFotoController::class, 'store'])->name('store');
        Route::delete('/{foto}', [ObraFotoController::class, 'destroy'])->name('destroy');
    });
});
// Rutas para Planos
Route::middleware(['auth'])->group(function () {
    Route::prefix('obras/{obra}/planos')->name('obras.planos.')->group(function () {
        Route::get('/', [ObraPlanoController::class, 'index'])->name('index');
        Route::post('/', [ObraPlanoController::class, 'store'])->name('store');
        Route::get('/{plano}/download', [ObraPlanoController::class, 'download'])->name('download');
        Route::delete('/{plano}', [ObraPlanoController::class, 'destroy'])->name('destroy');
    });
});

// Rutas para Contratos
Route::middleware(['auth'])->group(function () {
    Route::prefix('obras/{obra}/contratos')->name('obras.contratos.')->group(function () {
        Route::post('/', [ObraContratoController::class, 'store'])->name('store');
        Route::get('/{contrato}/download', [ObraContratoController::class, 'download'])->name('download');
        Route::delete('/{contrato}', [ObraContratoController::class, 'destroy'])->name('destroy');
    });
});
    
    // Rutas adicionales
    Route::patch('/works/{obra}/status', [ObraController::class, 'cambiarEstado'])->name('works.cambiar-estado');
    Route::patch('/works/{obra}/progress', [ObraController::class, 'updateProgress'])->name('works.update-progress');
    
    // API/AJAX routes
    Route::get('/api/works/status/{status}', [ObraController::class, 'byStatus'])->name('works.by-status');

    // ========== AGREGAR ESTAS LÍNEAS ==========
    // Detalles
    Route::post('/works/{obra}/detalles', [ObraDetalleController::class, 'store'])->name('obras.detalles.store');
    Route::delete('/works/{obra}/detalles/{detalle}', [ObraDetalleController::class, 'destroy'])->name('obras.detalles.destroy');

    // Cámaras
    Route::post('/works/{obra}/camaras', [ObraCamaraController::class, 'store'])->name('obras.camaras.store');
    Route::delete('/works/{obra}/camaras/{camara}', [ObraCamaraController::class, 'destroy'])->name('obras.camaras.destroy');

     Route::post('/works/{obra}/personas', [ObraPersonaController::class, 'store'])
        ->name('obras.personas.store');
    
        Route::put('/obras/{obra}/personas/{persona}', [ObraPersonaController::class, 'update'])
        ->name('obras.personas.update');

    Route::delete('/obras/{obra}/personas/{persona}', [ObraPersonaController::class, 'destroy'])
        ->name('obras.personas.destroy');
    // ==========================================
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Rutas de invitación (públicas, no requieren auth)
Route::get('/invitation/{token}', [App\Http\Controllers\InvitationController::class, 'show'])->name('invitation.show');
Route::post('/invitation/{token}', [App\Http\Controllers\InvitationController::class, 'accept'])->name('invitation.accept');
require __DIR__.'/auth.php';


Route::middleware('auth')->group(function () {
    Route::get('/usuarios/{user}/obras', [App\Http\Controllers\UserController::class, 'obras'])
        ->name('usuarios.obras');
    
    // Nueva ruta para asignar obras
    Route::post('/usuarios/{user}/obras/asignar', [App\Http\Controllers\UserController::class, 'asignarObras'])
        ->name('usuarios.obras.asignar');
});