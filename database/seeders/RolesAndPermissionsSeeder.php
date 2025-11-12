<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            // Clientes
            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'eliminar-clientes',
            'asignar-usuarios-clientes',

            // Obras
            'ver-obras',
            'crear-obras',
            'editar-obras',
            'eliminar-obras',

            // Usuarios
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Crear roles y asignar permisos

        // Superadmin - Tiene todos los permisos
        $superadmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $superadmin->givePermissionTo(Permission::all());

        // Admin - Puede gestionar sus clientes y obras
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'ver-obras',
            'crear-obras',
            'editar-obras',
            'eliminar-obras',
        ]);

        // User - Solo puede ver sus clientes y obras asignadas
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $user->givePermissionTo([
            'ver-clientes',
            'ver-obras',
        ]);

        $this->command->info('Roles y permisos creados exitosamente!');

        // Crear un usuario superadmin de prueba
        $superadminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => bcrypt('password'),
                'status' => 'active',
            ]
        );
        $superadminUser->assignRole('superadmin');
        $this->command->info('Usuario superadmin creado: superadmin@example.com / password');
    }
}