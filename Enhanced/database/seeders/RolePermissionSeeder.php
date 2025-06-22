<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $admin = Role::create(['name' => 'admin', 'description' => 'Administrator']);
        $student = Role::create(['name' => 'student', 'description' => 'Regular Student']);

        $permissions = ['create', 'read', 'update', 'delete'];
        foreach ($permissions as $perm) {
            $p = Permission::create(['name' => $perm]);
            $admin->permissions()->attach($p);
        }

        $student->permissions()->attach(Permission::where('name', 'read')->first());
    }
}
