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
use App\Http\Controllers\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========== RUTAS PÚBLICAS ==========
Route::redirect('/', '/login');

// Registro de nuevos usuarios
Route::get('/new-register', [NewRegisterController::class, 'showForm'])->name('new-register');
Route::post('/new-register', [NewRegisterController::class, 'store'])->name('new-register.store');

// Invitaciones (públicas, no requieren auth)
Route::get('/invitation/{token}', [App\Http\Controllers\InvitationController::class, 'show'])->name('invitation.show');
Route::post('/invitation/{token}', [App\Http\Controllers\InvitationController::class, 'accept'])->name('invitation.accept');

// Rutas de autenticación de Laravel
require __DIR__.'/auth.php';


// ========== RUTAS AUTENTICADAS ==========
Route::middleware(['auth', 'verified', 'profile.complete'])->group(function () {
    
    // ---------- DASHBOARD ----------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    
    // ---------- CLIENTES ----------
    // Listado y creación (sin restricción de cliente específico)
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

    // Rutas específicas de cliente (CON verificación de acceso)
    Route::middleware(['cliente.access'])->group(function () {
        Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
        Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
        Route::get('/clientes/{cliente}/obras', [ClienteController::class, 'obras'])->name('clientes.obras');
        Route::post('/clientes/{cliente}/invitaciones', [ClienteController::class, 'storeInvitation'])->name('clientes.invitaciones.store');
    });
    
    
    // ---------- OBRAS ----------
    // Dashboard y búsqueda de obras (sin restricción, se filtra en controlador)
    Route::get('/works/dashboard', [ObraController::class, 'dashboard'])->name('works.dashboard');
    Route::get('/works/search', [ObraController::class, 'search'])->name('works.search');
    
    // Listado y creación de obras (sin restricción de obra específica)
    Route::get('/works', [ObraController::class, 'index'])->name('works.index');
    Route::get('/works/create', [ObraController::class, 'create'])->name('works.create');
    Route::post('/works', [ObraController::class, 'store'])->name('works.store');
    
    // API/AJAX routes (sin restricción, se filtra en controlador)
    Route::get('/api/works/status/{status}', [ObraController::class, 'byStatus'])->name('works.by-status');
    
    // Rutas específicas de obra (CON verificación de acceso)
    Route::middleware(['cliente.access'])->group(function () {
        // Operaciones CRUD sobre obra específica
        Route::get('/works/{obra}', [ObraController::class, 'show'])->name('works.show');
        Route::get('/works/{obra}/edit', [ObraController::class, 'edit'])->name('works.edit');
        Route::put('/works/{obra}', [ObraController::class, 'update'])->name('works.update');
        Route::delete('/works/{obra}', [ObraController::class, 'destroy'])->name('works.destroy');
        
        // Cambios de estado y progreso
        Route::patch('/works/{obra}/status', [ObraController::class, 'cambiarEstado'])->name('works.cambiar-estado');
        Route::patch('/works/{obra}/progress', [ObraController::class, 'updateProgress'])->name('works.update-progress');
        
        // Detalles de obra
        Route::post('/works/{obra}/detalles', [ObraDetalleController::class, 'store'])->name('obras.detalles.store');
        Route::delete('/works/{obra}/detalles/{detalle}', [ObraDetalleController::class, 'destroy'])->name('obras.detalles.destroy');

        // Cámaras de obra
        Route::post('/works/{obra}/camaras', [ObraCamaraController::class, 'store'])->name('obras.camaras.store');
        Route::delete('/works/{obra}/camaras/{camara}', [ObraCamaraController::class, 'destroy'])->name('obras.camaras.destroy');

        // Personas de obra
        Route::post('/works/{obra}/personas', [ObraPersonaController::class, 'store'])->name('obras.personas.store');
        Route::put('/obras/{obra}/personas/{persona}', [ObraPersonaController::class, 'update'])->name('obras.personas.update');
        Route::delete('/obras/{obra}/personas/{persona}', [ObraPersonaController::class, 'destroy'])->name('obras.personas.destroy');
        
        // Fotos de obra
        Route::prefix('obras/{obra}/fotos')->name('obras.fotos.')->group(function () {
            Route::post('/', [ObraFotoController::class, 'store'])->name('store');
            Route::delete('/{foto}', [ObraFotoController::class, 'destroy'])->name('destroy');
        });
        
        // Planos de obra
        Route::prefix('obras/{obra}/planos')->name('obras.planos.')->group(function () {
            Route::get('/', [ObraPlanoController::class, 'index'])->name('index');
            Route::post('/', [ObraPlanoController::class, 'store'])->name('store');
            Route::get('/{plano}/download', [ObraPlanoController::class, 'download'])->name('download');
            Route::delete('/{plano}', [ObraPlanoController::class, 'destroy'])->name('destroy');
        });

        // Contratos de obra
        Route::prefix('obras/{obra}/contratos')->name('obras.contratos.')->group(function () {
            Route::post('/', [ObraContratoController::class, 'store'])->name('store');
            Route::get('/{contrato}/download', [ObraContratoController::class, 'download'])->name('download');
            Route::delete('/{contrato}', [ObraContratoController::class, 'destroy'])->name('destroy');
        });
    });
});


// ========== RUTAS DE PERFIL ==========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ========== RUTAS DE GESTIÓN DE USUARIOS ==========
Route::middleware('auth')->group(function () {
    // CRUD de usuarios
    Route::resource('users', UserManagementController::class);

    // Obras de usuario
    Route::get('/usuarios/{user}/obras', [App\Http\Controllers\UserController::class, 'obras'])->name('usuarios.obras');
    Route::post('/usuarios/{user}/obras/asignar', [App\Http\Controllers\UserController::class, 'asignarObras'])->name('usuarios.obras.asignar');
});