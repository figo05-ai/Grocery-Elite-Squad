<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage catalog', // For Categories & Meals
            'manage users', // For user management
            'view all orders', // For Admin
            'manage orders', // For Admin
            'view assigned orders', // For Driver
            'update assigned orders', // For Driver
            'place orders', // For Customer
            'view own orders', // For Customer
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and assign created permissions

        // 1. Customer
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->givePermissionTo(['place orders', 'view own orders']);

        // 2. Driver
        $driverRole = Role::firstOrCreate(['name' => 'driver']);
        $driverRole->givePermissionTo(['view assigned orders', 'update assigned orders']);

        // 3. Admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}
