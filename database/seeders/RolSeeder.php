<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::where('name', 'Administrador')->first();
        $role2 = Role::where('name', 'Municipio')->first();
        $role3 = Role::where('name', 'Dependencia')->first();
        
        if (!$role1) {
            $role1 = Role::create(['name' => 'Administrador']);
        }
        
        if (!$role2) {
            $role2 = Role::create(['name' => 'Municipio']);
        }   

        if (!$role3) {
            $role3 = Role::create(['name' => 'Dependencia']);
        }

        if (!Permission::where('name', 'VerUsuarios')->exists()) {
            Permission::create(['name' => 'VerUsuarios']);
        }

        $permission1 = Permission::where('name', 'VerUsuarios')->first();

        if ($role1 && !$role1->hasPermissionTo($permission1)) {
            $role1->givePermissionTo($permission1);
        }
    }
}
