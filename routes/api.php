<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\ObraController;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Controllers\Api\V1\UserProfileController;


// Versión 1 de la API
Route::prefix('v1')->group(function () {
    
    // Rutas públicas
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']); 

    // Rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/me', [UserProfileController::class, 'show']);
        Route::put('/me', [UserProfileController::class, 'update']); 

             // Clientes
        Route::get('/clientes', [ClienteController::class, 'index']);
        Route::get('/clientes/{cliente}', [ClienteController::class, 'show']);
        // Route::get('/clientes/{cliente}/obras', [ClienteController::class, 'obras']);
        // Route::get('/clientes/{cliente}/obras', [ClienteController::class, 'obras']);


        Route::get('/obras', [ObraController::class, 'index']);
        Route::get('/obras/{obra}', [ObraController::class, 'show']);
        Route::get('/obras/cliente/{cliente}', [ObraController::class, 'byCliente']);


    });


});