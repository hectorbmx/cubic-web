<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Si usas Spatie Permissions, asegúrate de tener los roles creados
        // y ejecuta el PermissionSeeder antes de este.
        $superAdminRoleId = DB::table('roles')->where('name', 'SuperAdmin')->value('id');

        // Crear o actualizar el usuario SuperAdmin
        $user = DB::table('users')->updateOrInsert(
            ['email' => 'hecrtorbmx@gmail.com'],
            [
                'name' => 'Super Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Obtener el ID del usuario recién creado
        $userId = DB::table('users')->where('email', 'superadmin@cubic.com')->value('id');

        // Si tienes una tabla pivot model_has_roles (Spatie Permission)
        if ($superAdminRoleId && $userId) {
            DB::table('model_has_roles')->updateOrInsert([
                'role_id' => $superAdminRoleId,
                'model_type' => 'App\\Models\\User',
                'model_id' => $userId,
            ]);
        }

        $this->command->info('✅ Usuario SuperAdmin creado correctamente.');
    }
}
