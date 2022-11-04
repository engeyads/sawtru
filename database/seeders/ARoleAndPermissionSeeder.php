<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ARoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'list-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'list-settings']);
        Permission::create(['name' => 'edit-settings']);

        Permission::create(['name' => 'list-project']);
        Permission::create(['name' => 'list-self-project']);
        Permission::create(['name' => 'create-project']);
        Permission::create(['name' => 'edit-self-project']);
        Permission::create(['name' => 'delete-self-project']);
        Permission::create(['name' => 'edit-projects']);
        Permission::create(['name' => 'delete-projects']);

        Permission::create(['name' => 'list-purchases']);
        Permission::create(['name' => 'list-self-purchases']);
        Permission::create(['name' => 'create-purchases']);
        Permission::create(['name' => 'edit-self-purchases']);
        Permission::create(['name' => 'delete-self-purchases']);
        Permission::create(['name' => 'edit-purchases']);
        Permission::create(['name' => 'assembling-projects']);
        Permission::create(['name' => 'delete-purchases']);

        Permission::create(['name' => 'pdf-project']);

        Permission::create(['name' => 'list-role']);
        Permission::create(['name' => 'create-role']);
        Permission::create(['name' => 'edit-role']);
        Permission::create(['name' => 'delete-role']);

        $adminRole = Role::create(['name' => 'Admin']);
        $engineerRole = Role::create(['name' => 'Engineer']);
        $purchaserRole = Role::create(['name' => 'Purchaser']);

        $adminRole->givePermissionTo([
            'list-users',
            'create-users',
            'edit-users',
            'delete-users',
            'list-settings',
            'edit-settings',
            'list-project',
            'list-self-project',
            'create-project',
            'edit-self-project',
            'delete-self-project',
            'edit-projects',
            'assembling-projects',
            'delete-projects',
            'list-purchases',
            'list-self-purchases',
            'create-purchases',
            'edit-self-purchases',
            'delete-self-purchases',
            'edit-purchases',
            'delete-purchases',
            'pdf-project',
            'list-role',
            'create-role',
            'edit-role',
            'delete-role'
        ]);

        $engineerRole->givePermissionTo([
            'list-self-project',
            'create-project',
            'edit-self-project',
            'delete-self-project',
            'assembling-projects',
            'create-purchases'
        ]);

        $purchaserRole->givePermissionTo([
            'list-purchases',
            'create-purchases',
            'edit-self-purchases',
            'delete-self-purchases',
        ]);
    }
}
