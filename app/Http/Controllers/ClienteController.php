<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // ← AGREGAR ESTA LÍNEA
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvitation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class ClienteController extends Controller
{
    /**
     * Muestra la lista de clientes según el rol del usuario
     */
   public function index(Request $request)
{
    $user = Auth::user();
    // Query base con conteo de obras
    $clientes = \App\Models\Cliente::visibleFor(auth()->user())
    ->withCount('obras')
    ->latest()
    ->get();

    $query = Cliente::withCount([
        'obras as obras_activas_count' => function($query) {
            $query->whereIn('status', ['planning', 'in_progress']);
        }
    ]);

    // Búsqueda
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    $clientes = $query->orderBy('name')->paginate(15);

    return view('clientes.index', compact('clientes'));
}

    /**
     * Muestra el formulario para crear un cliente
     */
    public function create()
{
    // Solo superadmin puede crear clientes
    $this->authorize('create', Cliente::class);

    return view('clientes.create');
}

    /**
     * Guarda un nuevo cliente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'tax_id' => 'nullable|string|max:50',
            
            // Campos para crear usuario
            'create_user' => 'nullable|boolean',
            'user_email' => 'required_if:create_user,true|nullable|email|max:255',
            'user_first_name' => 'required_if:create_user,true|nullable|string|max:255',
            'user_last_name' => 'required_if:create_user,true|nullable|string|max:255',
            'user_phone' => 'nullable|string|max:20',
            'user_role' => 'required_if:create_user,true|in:company_admin,gestor,viewer',
        ]);

        DB::beginTransaction();

        try {
            // Crear el cliente
            $cliente = Cliente::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'tax_id' => $validated['tax_id'],
                'status' => 'active',
            ]);

            // Si se marcó "Crear usuario"
            if ($request->create_user) {
                $userEmail = $validated['user_email'];
                
                // Verificar si el usuario ya existe
                $user = User::where('email', $userEmail)->first();

                if (!$user) {
                    // Crear nuevo usuario sin contraseña
                    $user = User::create([
                        'first_name' => $validated['user_first_name'],
                        'last_name' => $validated['user_last_name'],
                        'name' => $validated['user_first_name'] . ' ' . $validated['user_last_name'],
                        'email' => $userEmail,
                        'phone' => $validated['user_phone'] ?? null,
                        'password' => null, // Sin contraseña hasta que acepte la invitación
                        'status' => 'active',
                    ]);
                }

                // Verificar si ya está vinculado a esta empresa
                $existingMembership = $cliente->usuarios()->where('user_id', $user->id)->exists();

                if (!$existingMembership) {
                    // Vincular usuario a la empresa
                    $cliente->usuarios()->attach($user->id, [
                        'role' => $validated['user_role'],
                        'status' => 'invited',
                        'invited_at' => now(),
                        'invited_by_user_id' => auth()->id(),
                    ]);

                    // Generar token de invitación
                    $token = $user->generateInvitationToken();

                    // Enviar email de invitación
                    // Mail::to($user->email)->send(new UserInvitation($user, $cliente, $token));
                    \Log::info('Invitación generada', [
    'user' => $user->email,
    'token' => $token,
    'url' => route('invitation.show', ['token' => $token])
]);
                } else {
                    // Si ya existe, solo actualizar el estado si es necesario
                    $membership = $cliente->usuarios()->where('user_id', $user->id)->first();
                    
                    if ($membership->pivot->status === 'suspended') {
                        $cliente->usuarios()->updateExistingPivot($user->id, [
                            'status' => 'invited',
                            'invited_at' => now(),
                            'invited_by_user_id' => auth()->id(),
                        ]);
                        
                        // Reenviar invitación
                        $token = $user->generateInvitationToken();
                        Mail::to($user->email)->send(new UserInvitation($user, $cliente, $token));
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('clientes.index')
                ->with('success', 'Cliente creado exitosamente' . ($request->create_user ? ' e invitación enviada.' : '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el cliente: ' . $e->getMessage());
        }
    }


    /**
     * Muestra los detalles de un cliente
     */
    public function show(Cliente $cliente)
    {
        // Verificar acceso
        $this->authorize('view', $cliente);

        $cliente->load([
            'obras' => function($query) {
                $query->latest();
            },
            'users'
        ]);

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Muestra el formulario para editar un cliente
     */
public function edit(Cliente $cliente)
{
    $this->authorize('update', $cliente);

    // Lista de todos los usuarios
    $usuarios = User::orderBy('name')->get();
    
    // IDs de usuarios ya asignados a este cliente
    $usuariosAsignados = $cliente->usuarios->pluck('id')->toArray();

    return view('clientes.edit', compact('cliente', 'usuarios', 'usuariosAsignados'));
}
    /**
     * Actualiza un cliente
     */
    public function update(Request $request, Cliente $cliente)
    {
        $this->authorize('update', $cliente);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clientes,email,' . $cliente->id,
            'phone' => 'nullable|string|max:20',
            'rfc' => 'nullable|string|max:13',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $cliente->update($validated);

        // Actualizar usuarios asignados (solo si es superadmin)
        if (Auth::user()->hasRole('superadmin') && $request->has('users')) {
            $cliente->users()->sync($request->users ?? []);
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Elimina un cliente
     */
    public function destroy(Cliente $cliente)
    {
        $this->authorize('delete', $cliente);

        try {
            $cliente->delete();
            return redirect()->route('clientes.index')
                ->with('success', 'Cliente eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el cliente porque tiene obras asociadas.');
        }
    }

    /**
     * Asignar/desasignar usuarios a un cliente
     */
    public function assignUsers(Request $request, Cliente $cliente)
    {
        $this->authorize('update', $cliente);

        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        $cliente->users()->sync($request->users);

        return redirect()->back()
            ->with('success', 'Usuarios asignados correctamente.');
    }
   public function storeInvitation(Request $request, Cliente $cliente)
{
    // 1) Autorizar (usa tu policy si aplica)
    $this->authorize('assignUsers', $cliente);

    // 2) Validar entrada
    $data = $request->validate([
        'email' => ['required','email','max:255'],
        'role'  => ['required','in:company_admin,gestor,viewer'],
        'scope' => ['required','in:global,partial'],
        'obras' => ['array'], // solo si scope=partial
        'obras.*' => ['integer'],
    ]);

    \Log::info('Invitación: inicio', ['cliente_id' => $cliente->id, 'payload' => $data]);

    DB::beginTransaction();
    try {
        // 3) Buscar o crear usuario por email
        $user = \App\Models\User::where('email', $data['email'])->first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $data['email'], // o separa nombre/apellido si los pides
                'email' => $data['email'],
                'password' => null,       // pendiente de setear en aceptación
                'status' => 'active',     // o 'pending', según tu flujo
            ]);
            \Log::info('Invitación: usuario creado', ['user_id' => $user->id]);
        } else {
            \Log::info('Invitación: usuario existente', ['user_id' => $user->id]);
        }

        // 4) Vincular a cliente en pivot (si no existe)
        $exists = $cliente->usuarios()->where('users.id', $user->id)->exists();
        if (!$exists) {
            $cliente->usuarios()->attach($user->id, [
                'role' => $data['role'],
                'status' => 'invited',
                'invited_at' => now(),
                'invited_by_user_id' => auth()->id(),
            ]);
            \Log::info('Invitación: cliente_user attach', ['cliente_id' => $cliente->id, 'user_id' => $user->id]);
        } else {
            // Si ya existe, puedes actualizar rol/estado si lo deseas
            $cliente->usuarios()->updateExistingPivot($user->id, [
                'role' => $data['role'],
                'status' => 'invited',
                'invited_at' => now(),
                'invited_by_user_id' => auth()->id(),
            ]);
            \Log::info('Invitación: cliente_user update', ['cliente_id' => $cliente->id, 'user_id' => $user->id]);
        }

        // 5) Alcance por obras (opcional)
        if ($data['scope'] === 'partial') {
            // Asumiendo que tienes pivot obra_user (obra_user: obra_id, user_id)
            // Primero limpia relaciones previas del usuario en obras de ESTE cliente (opcional)
            // \DB::table('obra_user')->whereIn('obra_id', $cliente->obras()->pluck('id'))->where('user_id', $user->id)->delete();

            // Luego asigna solo las seleccionadas
            $obraIds = $cliente->obras()->whereIn('id', $data['obras'] ?? [])->pluck('id')->all();
            if (!empty($obraIds)) {
                // Inserta relaciones; si usas relación en el modelo Obra, puedes usar attach/sync
                foreach ($obraIds as $obraId) {
                    \DB::table('obra_user')->updateOrInsert(
                        ['obra_id' => $obraId, 'user_id' => $user->id],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
                \Log::info('Invitación: obras asignadas', ['user_id' => $user->id, 'obras' => $obraIds]);
            }
        } else {
            \Log::info('Invitación: alcance global (todas las obras)');
        }

        // 6) Generar token de invitación y (opcional) enviar correo
        $token = method_exists($user, 'generateInvitationToken') ? $user->generateInvitationToken() : \Str::random(40);
        \Log::info('Invitación generada', [
            'user' => $user->email,
            'token' => $token,
            'url' => route('invitation.show', ['token' => $token]),
        ]);

        // Mail::to($user->email)->send(new \App\Mail\UserInvitation($user, $cliente, $token));

        DB::commit();

        return back()->with('success', 'Invitación enviada correctamente.');
    } catch (\Throwable $e) {
        DB::rollBack();
        \Log::error('Invitación: error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return back()->with('error', 'No se pudo enviar la invitación: '.$e->getMessage());
    }
}
/**
 * Muestra las obras de un cliente específico
 */
public function obras(Cliente $cliente)
{
    // Verificar acceso
    $this->authorize('view', $cliente);
    
    // Cargar obras con información adicional
    $obras = $cliente->obras()
        ->withCount('detalles')
        ->withCount('camaras')
        ->withCount('planos')
        ->withCount('contratos')
        ->withCount('fotos')
        ->orderBy('created_at', 'desc')
        ->paginate(15);
    
    return view('clientes.obras', compact('cliente', 'obras'));
}

}