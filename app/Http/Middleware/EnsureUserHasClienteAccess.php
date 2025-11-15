<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasClienteAccess
{
    /**
     * Handle an incoming request.
     */
   public function handle(Request $request, Closure $next): Response
{
    $user = auth()->user();
    
    // SuperAdmin tiene acceso a todo
    if ($user && $user->isSuperAdmin()) {
        return $next($request);
    }
    
    $clienteId = $this->getClienteIdFromRequest($request);
    
    // Si no hay cliente_id, permitir
    if (!$clienteId) {
        return $next($request);
    }
    
    // Verificar acceso
    if ($user && $user->esClienteDeUsuario($clienteId)) {
        return $next($request);
    }
    
    // DENEGADO - Responder según tipo de request
    if ($request->expectsJson() || $request->is('api/*')) {
        return response()->json([
            'message' => 'No tienes acceso a este cliente.',
            'error' => 'forbidden'
        ], 403);
    }
    
    abort(403, 'No tienes acceso a este cliente.');
}
    
    /**
     * Obtener cliente_id desde diferentes fuentes del request
     */
    private function getClienteIdFromRequest(Request $request): ?int
    {
        // 1. Desde parámetro de ruta {cliente}
        if ($request->route('cliente')) {
            $cliente = $request->route('cliente');
            return is_object($cliente) ? $cliente->id : $cliente;
        }
        
        // 2. Desde parámetro de ruta {obra} (obra tiene client_id)
        if ($request->route('obra')) {
            $obra = $request->route('obra');
            return is_object($obra) ? $obra->client_id : null; // ← CAMBIO: cliente_id → client_id
        }
        
        // 3. Desde input del formulario
        if ($request->has('client_id')) {
            return $request->input('client_id');
        }
        
        // 4. Desde input del formulario (nombre alternativo)
        if ($request->has('cliente_id')) {
            return $request->input('cliente_id');
        }
        
        return null;
    }
}