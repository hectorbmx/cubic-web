<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\V1\RegisterRequest;

class AuthController extends Controller
{
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas son incorrectas.'],
        ]);
    }

        // Roles + panel
    $roles = $user->getRoleNames();
    $panel = $roles->contains('superadmin') ? 'superadmin' : 'panel';

    // Clientes asignados (opción C)
    $isSuperAdmin = $user->hasRole('superadmin');

    $clientesQuery = $isSuperAdmin
        ? Cliente::query()->select('id', 'name')   // si superadmin ve todo
        : $user->clientes()->select('clientes.id', 'clientes.name');

    $clientes = $clientesQuery->orderBy('name')->get();

    if (!$isSuperAdmin && $clientes->isEmpty()) {
        return response()->json([
            'message' => 'Usuario sin cliente asignado.',
        ], 403);
    }

    $clienteActivoId = $clientes->count() === 1 ? $clientes->first()->id : $clientes->first()->id; 
    // (más adelante lo puedes mejorar guardando "último cliente usado")
    
    $clientesIds = $user->getClientesIds();
    // Eliminar tokens anteriores (opcional)
    $user->tokens()->delete();

    // Crear nuevo token
    $token = $user->createToken('mobile-app')->plainTextToken;

    // Roles + panel (para que la app decida UI)
    $roles = $user->getRoleNames(); // Collection
    $panel = $roles->contains('superadmin') ? 'superadmin' : 'panel';

    return response()->json([
    'user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'panel' => $panel,
        'roles' => $roles->values(),
        'permissions' => $user->getAllPermissions()->pluck('name')->values(),

        // NUEVO
        'clientes' => $clientes,
        'cliente_activo_id' => $clienteActivoId,
    ],
    'token' => $token,
]);

}


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }

public function me(Request $request)
{
    $user = $request->user();
    $user->load('clientes', 'roles','obras');

    $roles = $user->roles->pluck('name'); // Collection

    // Definir $panel SIEMPRE
    $panel = $roles->contains('superadmin') ? 'superadmin' : 'panel';

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,

        'panel' => $panel,                // <-- aquí ya existe
        'roles' => $roles->values(),
        'permissions' => $user->getAllPermissions()->pluck('name')->values(),

        'clientes' => $user->clientes->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'name' => $cliente->name,
                'email' => $cliente->email,
            ];
        }),
          'obras' => $user->obras->map(function ($obra) {
            return [
                'id' => $obra->id,
                'client_id' => $obra->client_id,
                'name' => $obra->name,
                'code' => $obra->code,
                'status' => $obra->status,
                'role' => $obra->pivot->role ?? null, // viene de withPivot('role')
            ];
        })->values(),

        'obra_ids' => $user->obras->pluck('id')->values(),

        // compatibilidad
        'client_id' => $user->clientes->first()->id ?? null,
        'clientId' => $user->clientes->first()->id ?? null,
        'client_name' => $user->clientes->first()->name ?? null,
        'clientName' => $user->clientes->first()->name ?? null,
    ]);
}


    public function register(RegisterRequest $request)
        {
            try {
                // Buscar usuario por email
                $user = User::where('email', $request->email)->first();

                // Verificar que tenga invitation_token (fue invitado)
                if (!$user || !$user->invitation_token) {
                    return response()->json([
                        'message' => 'No se encontró una invitación válida para este correo electrónico'
                    ], 404);
                }

                // Verificar que no haya aceptado ya la invitación
                if ($user->invitation_accepted_at) {
                    return response()->json([
                        'message' => 'Esta invitación ya fue aceptada. Por favor inicia sesión.'
                    ], 400);
                }

                // Actualizar contraseña y marcar invitación como aceptada
                $user->password = Hash::make($request->password);
                $user->invitation_accepted_at = now();
                $user->save();

                // Crear token para auto-login (opcional)
                $token = $user->createToken('mobile-app')->plainTextToken;

                return response()->json([
                    'message' => 'Registro completado exitosamente',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'roles' => $user->getRoleNames(),
                    ],
                    'token' => $token,
                ], 201);

            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Error al procesar el registro',
                    'error' => $e->getMessage()
                ], 500);
            }
    }
}