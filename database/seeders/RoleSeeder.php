<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $fasyankes = Role::firstOrCreate(['name' => 'Fasyankes']);
        $dinkes = Role::firstOrCreate(['name' => 'Dinkes']);
        $pasien = Role::firstOrCreate(['name' => 'Pasien']);

        // Create permissions if needed
        $permissions = [
            'manage users',
            'view dashboard',
            'manage fasyankes',
            'manage dinkes',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $fasyankes->givePermissionTo([
            'view dashboard',
            'view reports',
        ]);

        $dinkes->givePermissionTo([
            'manage users',
            'view dashboard',
            'manage fasyankes',
            'manage dinkes',
            'view reports',
        ]);

        // Pasien doesn't get dashboard access
        // No permissions assigned to Pasien role
    }
}
