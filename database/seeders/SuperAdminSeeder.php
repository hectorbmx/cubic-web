<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'superadmin@example.com';

        $superAdminRoleId = DB::table('roles')
            ->where('name', 'superadmin')
            ->where('guard_name', 'web')
            ->value('id');

        DB::table('users')->updateOrInsert(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $userId = DB::table('users')->where('email', $email)->value('id');

        if ($superAdminRoleId && $userId) {
            DB::table('model_has_roles')->updateOrInsert(
                [
                    'role_id' => $superAdminRoleId,
                    'model_type' => 'App\\Models\\User',
                    'model_id' => $userId,
                ],
                []
            );
        }

        $this->command->info('✅ Usuario SuperAdmin creado correctamente.');
    }
}