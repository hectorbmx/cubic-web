<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\User;


    /**
     * Determina si el usuario puede ver cualquier cliente
     */
    class ClientePolicy
{
    // Se ejecuta antes de cualquier método de la policy
    public function before(User $user, string $ability)
    {
        if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return true; // superadmin pasa todo
        }
        return null; // deja continuar a los demás métodos
    }

    public function viewAny(User $user): bool
    {
        return true; // el filtrado va en el controller
    }

    public function view(User $user, Cliente $cliente): bool
    {
        return $user->hasAccessToCliente($cliente->id);
    }

    public function create(User $user): bool
    {
        // si no eres superadmin (capturado en before), entonces false
        return false;
    }

    public function update(User $user, Cliente $cliente): bool
    {
        return $user->isCompanyAdmin($cliente->id);
    }

    public function delete(User $user, Cliente $cliente): bool
    {
        return false;
    }

    public function restore(User $user, Cliente $cliente): bool
    {
        return false;
    }

    public function forceDelete(User $user, Cliente $cliente): bool
    {
        return false;
    }

    public function assignUsers(User $user, Cliente $cliente): bool
    {
        return $user->isCompanyAdmin($cliente->id);
    }

    
}