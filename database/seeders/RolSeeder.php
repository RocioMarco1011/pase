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
        //ROLES 1, 2 y 3
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

        //PERMISO 1
        if (!Permission::where('name', 'VerUsuarios')->exists()) {
            Permission::create(['name' => 'VerUsuarios']);
        }

        $permission1 = Permission::where('name', 'VerUsuarios')->first();

         //PERMISO 2
        if (!Permission::where('name', 'VerEstrategiasPrevenir')->exists()) {
            Permission::create(['name' => 'VerEstrategiasPrevenir']);
        }

        $permission2 = Permission::where('name', 'VerEstrategiasPrevenir')->first();

         //PERMISO 3
         if (!Permission::where('name', 'VerAccionesPrevenir')->exists()) {
            Permission::create(['name' => 'VerAccionesPrevenir']);
        }

        $permission3 = Permission::where('name', 'VerAccionesPrevenir')->first();

        //PERMISO 4
        if (!Permission::where('name', 'AñadirEstrategiasPrevenir')->exists()) {
            Permission::create(['name' => 'AñadirEstrategiasPrevenir']);
        }

        $permission4 = Permission::where('name', 'AñadirEstrategiasPrevenir')->first();
        
        //PERMISO 5
        if (!Permission::where('name', 'AñadirAccionesPrevenir')->exists()) {
            Permission::create(['name' => 'AñadirAccionesPrevenir']);
        }

        $permission5 = Permission::where('name', 'AñadirAccionesPrevenir')->first();

        //PERMISO 6
        if (!Permission::where('name', 'EliminarEvidenciaPrevenir')->exists()) {
            Permission::create(['name' => 'EliminarEvidenciaPrevenir']);
        }

        $permission6 = Permission::where('name', 'EliminarEvidenciaPrevenir')->first();


        //DAR PERMISO 1
        if ($role1 && !$role1->hasPermissionTo($permission1)) {
            $role1->givePermissionTo($permission1);
        }

        //DAR PERMISO 2
        if ($role1 && !$role1->hasPermissionTo($permission2)) {
            $role1->givePermissionTo($permission2);
        }

        //DAR PERMISO 3
        if ($role1 && !$role1->hasPermissionTo($permission3)) {
            $role1->givePermissionTo($permission3);
        }

        //DAR PERMISO 4
        if ($role1 && !$role1->hasPermissionTo($permission4)) {
            $role1->givePermissionTo($permission4);
        }

        //DAR PERMISO 5
        if ($role1 && !$role1->hasPermissionTo($permission5)) {
            $role1->givePermissionTo($permission5);
        }

        //DAR PERMISO 6
        if ($role1 && !$role1->hasPermissionTo($permission6)) {
            $role1->givePermissionTo($permission6);
        }
    }
}
