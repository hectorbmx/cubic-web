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

    // Ajusta el tamaño de página según necesidad
    $perPage = (int) $request->get('per_page', 50);
    $perPage = max(10, min($perPage, 200)); // límites sanos

    // SUPERADMIN: no uses whereIn(IDs enormes). Consulta directa y pagina.
    if ($user->hasRole('superadmin')) {
        $clientes = Cliente::query()
            ->select('id', 'name', 'email', 'phone', 'address')
            ->withCount('obras')
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'data' => collect($clientes->items())->map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'nombre' => $cliente->name,
                    'email' => $cliente->email,
                    'telefono' => $cliente->phone ?? null,
                    'direccion' => $cliente->address ?? null,
                    'obrasActivas' => $cliente->obras_count,
                ];
            }),
            'meta' => [
                'current_page' => $clientes->currentPage(),
                'last_page' => $clientes->lastPage(),
                'per_page' => $clientes->perPage(),
                'total' => $clientes->total(),
            ],
        ]);
    }

    // NO superadmin: usa la relación (mucho más eficiente que whereIn)
    $clientes = $user->clientes()
        ->select('clientes.id', 'clientes.name', 'clientes.email', 'clientes.phone', 'clientes.address')
        ->withCount('obras')
        ->orderBy('clientes.name')
        ->get();

    return response()->json([
        'data' => $clientes->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'nombre' => $cliente->name,
                'email' => $cliente->email,
                'telefono' => $cliente->phone ?? null,
                'direccion' => $cliente->address ?? null,
                'obrasActivas' => $cliente->obras_count,
            ];
        }),
        'meta' => [
            'current_page' => 1,
            'last_page' => 1,
            'per_page' => $clientes->count(),
            'total' => $clientes->count(),
        ],
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