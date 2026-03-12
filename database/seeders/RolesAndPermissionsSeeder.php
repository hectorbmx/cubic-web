<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'eliminar-clientes',
            'asignar-usuarios-clientes',

            'ver-obras',
            'crear-obras',
            'editar-obras',
            'eliminar-obras',

            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superadmin = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'web',
        ]);
        $superadmin->syncPermissions(Permission::all());

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        $admin->syncPermissions([
            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'ver-obras',
            'crear-obras',
            'editar-obras',
            'eliminar-obras',
        ]);

        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);
        $user->syncPermissions([
            'ver-clientes',
            'ver-obras',
        ]);

        $this->command->info('Roles y permisos creados exitosamente.');
    }
}