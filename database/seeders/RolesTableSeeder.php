<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $roles = [
            ['name' => 'superadmin', 'guard_name' => 'web'],
            ['name' => 'admin',      'guard_name' => 'web'],
            ['name' => 'user',       'guard_name' => 'web'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name'       => $role['name'],
                'guard_name' => $role['guard_name'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
