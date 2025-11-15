<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         
        // Verificar que el usuario tenga permisos
        if (!auth()->user()->hasAnyRole(['superadmin', 'admin'])) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
           
        $clientes = Cliente::orderBy('name')->get();
        // Obtener usuarios con sus relaciones
        $users = User::with(['roles', 'clientes', 'obras'])
            ->orderBy('name')
            ->paginate(15);

        // Obtener roles disponibles para el select
        $roles = $this->getAvailableRoles();

        return view('users.index', compact('users', 'roles','clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar permisos
        if (!auth()->user()->hasAnyRole(['superadmin', 'admin'])) {
            abort(403, 'No tienes permisos para crear usuarios.');
        }

        // Obtener roles disponibles según el usuario actual
        $roles = $this->getAvailableRoles();

        return view('users.create', compact('roles'));
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    // Verificar permisos
    if (!auth()->user()->hasAnyRole(['superadmin', 'admin'])) {
        return response()->json([
            'success' => false,
            'message' => 'No tienes permisos para crear usuarios.'
        ], 403);
    }

    // Validación base
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'role' => ['required', 'exists:roles,name'],
        'clientes' => ['nullable', 'array'],
        'clientes.*' => ['exists:clientes,id']
    ]);

   // Validación adicional: solo USER debe tener al menos 1 cliente
    if ($request->role === 'user') {
        $request->validate([
            'clientes' => ['required', 'array', 'min:1']
        ], [
            'clientes.required' => 'Los usuarios con rol "user" deben tener al menos un cliente asignado.',
            'clientes.min' => 'Debes seleccionar al menos un cliente.'
        ]);
    }

    // Verificar que el usuario actual pueda asignar ese rol
    $this->checkRolePermission($request->role);

    DB::beginTransaction();

    try {
        // Dividir el nombre en first_name y last_name
        $nameParts = explode(' ', $request->name, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        // Crear el usuario SIN contraseña
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $request->name,
            'email' => $request->email,
            'password' => null,
            'status' => 'invited',
            'phone' => $request->phone ?? null, // Agregar teléfono si existe
        ]);

        // Asignar el rol global de Spatie
        $user->assignRole($request->role);

        // NUEVO: Asignar clientes si tiene
      
        if (!empty($request->clientes)) {
            // Determinar rol interno basado en rol global
            $rolInterno = match($request->role) {
                'superadmin' => null, // SuperAdmin no necesita rol interno
                'admin' => 'company_admin',
                'user' => 'viewer',
                default => 'viewer'
            };
            
            foreach ($request->clientes as $clienteId) {
                $user->clientes()->attach($clienteId, [
                    'role' => $rolInterno,
                    'status' => 'active',
                    'invited_at' => now(),
                    'invited_by_user_id' => auth()->id()
                ]);
            }
        }

        // Generar token de invitación
        $token = $user->generateInvitationToken();

        // Enviar email de invitación (descomenta cuando esté configurado)
        // Mail::to($user->email)->send(new UserInvitation($user, $token));
        
        \Log::info('Invitación de usuario generada', [
            'user' => $user->email,
            'role' => $request->role,
            'clientes' => $request->clientes ?? [],
            'token' => $token,
            'url' => route('invitation.show', ['token' => $token])
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado exitosamente. Se ha enviado una invitación al correo electrónico.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Error al crear usuario', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Error al crear el usuario: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Cargar relaciones
        $user->load(['roles', 'clientes', 'obras.cliente']);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
 * Obtener datos del usuario para edición (AJAX)
 */
public function edit(User $user)
{
    // Verificar permisos
    if (!auth()->user()->hasAnyRole(['superadmin', 'admin'])) {
        return response()->json(['message' => 'No autorizado'], 403);
    }

    // Admin no puede editar superadmin
    if (auth()->user()->hasRole('admin') && $user->hasRole('superadmin')) {
        return response()->json(['message' => 'No autorizado'], 403);
    }

    // Cargar relación de clientes
    $user->load('clientes');

    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role' => $user->roles->first()->name ?? '',
            'clientes' => $user->clientes->pluck('id')->toArray(), // ← AGREGADO
        ],
        'roles' => $this->getAvailableRoles()
    ]);
}


/**
 * Update the specified resource in storage.
 */
public function update(Request $request, User $user)
{
    // Verificar permisos
    if (!auth()->user()->hasAnyRole(['superadmin', 'admin'])) {
        return response()->json([
            'success' => false,
            'message' => 'No tienes permisos para editar usuarios.'
        ], 403);
    }

    // Admin no puede editar superadmin
    if (auth()->user()->hasRole('admin') && $user->hasRole('superadmin')) {
        return response()->json([
            'success' => false,
            'message' => 'No tienes permisos para editar este usuario.'
        ], 403);
    }

    // Validación base
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'role' => ['required', 'exists:roles,name'],
        'phone' => ['nullable', 'string', 'max:20'],
        'clientes' => ['nullable', 'array'],
        'clientes.*' => ['exists:clientes,id']
    ]);

    // Validación adicional: si NO es superadmin, debe tener al menos 1 cliente
    if ($request->role === 'user' && empty($request->clientes)) {
        return response()->json([
            'success' => false,
            'message' => 'Los usuarios con rol "user" deben tener al menos un cliente asignado.',
            'errors' => [
                'clientes' => ['Debes seleccionar al menos un cliente.']
            ]
        ], 422);
    }

    // Verificar que el usuario actual pueda asignar ese rol
    $this->checkRolePermission($request->role);

    DB::beginTransaction();

    try {
        // Dividir el nombre en first_name y last_name
        $nameParts = explode(' ', $request->name, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        // Actualizar datos básicos
        $user->update([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Sincronizar rol (reemplaza el rol anterior)
        $user->syncRoles([$request->role]);

        // Sincronizar clientes
        if (!empty($request->clientes)) {
            // Determinar rol interno basado en rol global
            $rolInterno = match($request->role) {
                'superadmin' => null,
                'admin' => 'company_admin',
                'user' => 'viewer',
                default => 'viewer'
            };
            
            $syncData = [];
            foreach ($request->clientes as $clienteId) {
                $existing = $user->clientes()->where('cliente_id', $clienteId)->first();
                
                $syncData[$clienteId] = [
                    'role' => $existing ? $existing->pivot->role : $rolInterno,
                    'status' => $existing ? $existing->pivot->status : 'active',
                    'invited_at' => $existing ? $existing->pivot->invited_at : now(),
                    'invited_by_user_id' => $existing ? $existing->pivot->invited_by_user_id : auth()->id()
                ];
            }
            
            $user->clientes()->sync($syncData);
        } else {
            // Si es superadmin sin clientes, desasociar todos
            $user->clientes()->detach();
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado exitosamente.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Error al actualizar usuario', [
            'user_id' => $user->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el usuario: ' . $e->getMessage()
        ], 500);
    }
}
/**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Solo superadmin puede eliminar usuarios
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Solo el superadmin puede eliminar usuarios.');
        }

        // No puede eliminarse a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminarte a ti mismo.');
        }

        // Eliminar usuario (las relaciones se manejan con onDelete en migraciones)
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Obtener roles disponibles según el usuario autenticado
     */
    private function getAvailableRoles()
    {
        $user = auth()->user();

        if ($user->hasRole('superadmin')) {
            // Superadmin puede asignar todos los roles
            return Role::all();
        }

        if ($user->hasRole('admin')) {
            // Admin puede asignar admin y user (NO superadmin)
            return Role::whereIn('name', ['admin', 'user'])->get();
        }

        // User no puede asignar roles
        return collect();
    }

    /**
     * Verificar si el usuario actual puede asignar el rol especificado
     */
    private function checkRolePermission($roleName)
    {
        $user = auth()->user();

        // Superadmin puede asignar cualquier rol
        if ($user->hasRole('superadmin')) {
            return true;
        }

        // Admin puede asignar admin y user (NO superadmin)
        if ($user->hasRole('admin') && in_array($roleName, ['admin', 'user'])) {
            return true;
        }

        // Si llega aquí, no tiene permisos
        abort(403, 'No tienes permisos para asignar este rol.');
    }
    /**
         * Método auxiliar para la vista (obtener roles disponibles)
         */
        private function getAvailableRolesForView()
        {
            return $this->getAvailableRoles();
        }
}