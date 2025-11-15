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
    
    // DEBUG
    \Log::info('🔒 Middleware ClienteAccess', [
        'user_id' => $user->id,
        'is_superadmin' => $user->isSuperAdmin(),
        'route' => $request->route()->getName(),
    ]);
    
    // SuperAdmin tiene acceso a todo
    if ($user && $user->isSuperAdmin()) {
        \Log::info('✅ SuperAdmin - acceso permitido');
        return $next($request);
    }
    
    // Obtener cliente_id del request
    $clienteId = $this->getClienteIdFromRequest($request);
    
    \Log::info('🔍 Cliente ID detectado', [
        'cliente_id' => $clienteId,
    ]);
    
    // Si no hay cliente_id en la request, permitir
    if (!$clienteId) {
        \Log::info('⚠️ No hay cliente_id - permitiendo acceso');
        return $next($request);
    }
    
    // Verificar acceso
    $tieneAcceso = $user->esClienteDeUsuario($clienteId);
    
    \Log::info('🔐 Verificación de acceso', [
        'cliente_id' => $clienteId,
        'tiene_acceso' => $tieneAcceso,
        'clientes_usuario' => $user->clientes->pluck('id')->toArray(),
    ]);
    
    if ($user && $tieneAcceso) {
        \Log::info('✅ Acceso permitido');
        return $next($request);
    }
    
    \Log::error('❌ Acceso DENEGADO', [
        'cliente_id' => $clienteId,
        'clientes_usuario' => $user->clientes->pluck('id')->toArray(),
    ]);
    
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