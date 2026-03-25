<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class RolePermissionController extends Controller
{
   public function index()
    {
        $roles = Role::query()
            ->with('permissions')
            ->withCount('permissions')
            ->orderBy('name')
            ->get();

        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

  public function storePermission(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:permissions,name'],
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Permiso creado correctamente.');
    }
    public function syncRolePermissions(Request $request)
    {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::findOrFail($request->role_id);

        // Convertimos IDs a nombres (Spatie usa nombres)
        $permissionNames = Permission::whereIn('id', $request->permissions ?? [])
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissionNames);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Permisos actualizados correctamente.');
    }
}