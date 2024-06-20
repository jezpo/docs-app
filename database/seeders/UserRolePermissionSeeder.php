<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'view role', 'create role', 'update role', 'delete role',
            'view permission', 'create permission', 'update permission', 'delete permission',
            'view user', 'create user', 'update user', 'delete user',
            'create gestion', 'delete gestion', 'update gestion', 'view gestion',
            'toggle user status', 'view reports',
            'docs-list', 'docs-create', 'docs-edit', 'docs-view', 'docs-delete',
            'programa-create', 'programa-delete', 'programa-edit', 'programa-list'
        ];

        // Create permissions if they do not exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to super-admin role
        $superAdminRole->givePermissionTo($permissions);

        // Assign specific permissions to admin role
        $adminPermissions = [
            'create role', 'view role', 'update role',
            'create permission', 'view permission',
            'create user', 'view user', 'update user',
            'docs-create', 'docs-delete', 'docs-edit', 'docs-list', 'docs-view', 
            'programa-create', 'programa-list'
        ];
        $adminRole->givePermissionTo($adminPermissions);

        // Assign specific permissions to staff role
        $staffPermissions = [
            'docs-create', 'docs-delete', 'docs-edit', 'docs-list', 'docs-view', 
            'programa-create'
        ];
        $staffRole->givePermissionTo($staffPermissions);

        // Assign specific permissions to user role
        $userPermissions = [
            'docs-create', 'docs-delete', 'docs-edit', 'docs-list', 'docs-view', 
        ];
        $userRole->givePermissionTo($userPermissions);

        // Create users and assign roles
        $superAdminUser = User::firstOrCreate([
            'email' => 'superadmin@gmail.com',
        ], [
            'name' => 'Super Admin',
            'last_name' => 'Lastname',
            'ci' => '1111111',
            'password' => Hash::make('12345678'),
            'status' => 1
        ]);
        $superAdminUser->assignRole($superAdminRole);

        $adminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'name' => 'Admin',
            'last_name' => 'Lastname',
            'ci' => '2222222',
            'password' => Hash::make('12345678'),
            'status' => 1
        ]);
        $adminUser->assignRole($adminRole);

        $staffUser = User::firstOrCreate([
            'email' => 'staff@gmail.com',
        ], [
            'name' => 'Staff',
            'last_name' => 'Lastname',
            'ci' => '3333333',
            'password' => Hash::make('12345678'),
            'status' => 1
        ]);
        $staffUser->assignRole($staffRole);

        $regularUser = User::firstOrCreate([
            'email' => 'user@gmail.com',
        ], [
            'name' => 'User',
            'last_name' => 'Lastname',
            'ci' => '4444444',
            'password' => Hash::make('12345678'),
            'status' => 1
        ]);
        $regularUser->assignRole($userRole);
    }
}
