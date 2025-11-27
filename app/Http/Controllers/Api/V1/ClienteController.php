<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    //estos funcionan antes de configurar los roles
     public function index(Request $request)
{
    $user = $request->user();
    
    // Usar el método getClientesIds() que ya creamos
    $clientesIds = $user->getClientesIds();
    
    // Si es SuperAdmin o Admin sin clientes, getClientesIds() devuelve todos los IDs
    $clientes = Cliente::whereIn('id', $clientesIds)
        ->withCount('obras')
        ->orderBy('name')
        ->get();

    return response()->json([
        'clientes' => $clientes->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'nombre' => $cliente->name,
                'email' => $cliente->email,
                'telefono' => $cliente->phone ?? null,
                'direccion' => $cliente->address ?? null,
                'obrasActivas' => $cliente->obras_count,
            ];
        })
    ]);
}

    public function show(Request $request, Cliente $cliente)
    {
        $user = $request->user();

        // Verificar que el usuario tenga acceso a este cliente
        if (!$user->hasRole('superadmin') && !$user->clientes->contains($cliente->id)) {
            return response()->json([
                'message' => 'No tienes acceso a este cliente'
            ], 403);
        }

        $cliente->load('obras');

        return response()->json([
            'cliente' => [
                'id' => $cliente->id,
                'nombre' => $cliente->name,
                'email' => $cliente->email,
                'telefono' => $cliente->phone ?? null,
                'direccion' => $cliente->address ?? null,
                'obrasActivas' => $cliente->obras->count(),
                'obras' => $cliente->obras->map(function ($obra) {
                    return [
                        'id' => $obra->id,
                        'nombre' => $obra->name,
                        'estado' => $obra->status,
                        'progreso' => $obra->progress_pct ?? 0,
                    ];
                })
            ]
        ]);
    }
}