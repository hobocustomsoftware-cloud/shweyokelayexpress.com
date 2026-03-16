<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_names = [
            'Admin',
            'User',
            'Accountant',
        ];
        foreach ($role_names as $role_name) {
            $role = Role::firstOrCreate(['name' => $role_name]);
            $permissions = Permission::all();
            if ($permissions->isNotEmpty()) {
                $role->syncPermissions($permissions);
            }
        }
    }
}
