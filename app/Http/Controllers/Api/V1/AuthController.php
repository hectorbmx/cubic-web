<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        // Eliminar tokens anteriores (opcional)
        $user->tokens()->delete();

        // Crear nuevo token
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
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
    $user->load('clientes', 'roles');
    
    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'roles' => $user->roles->pluck('name'),
        'permissions' => $user->getAllPermissions()->pluck('name'),
        'clientes' => $user->clientes->map(function($cliente) {
            return [
                'id' => $cliente->id,
                'name' => $cliente->name,
                'email' => $cliente->email,
            ];
        }),
        // Mantener compatibilidad con código antiguo (primer cliente como "activo")
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