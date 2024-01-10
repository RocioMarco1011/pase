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

        //PERMISO 7
         if (!Permission::where('name', 'VerEstrategiasAtender')->exists()) {
            Permission::create(['name' => 'VerEstrategiasAtender']);
        }

        $permission7 = Permission::where('name', 'VerEstrategiasAtender')->first();

         //PERMISO 8
         if (!Permission::where('name', 'VerAccionesAtender')->exists()) {
            Permission::create(['name' => 'VerAccionesAtender']);
        }

        $permission8 = Permission::where('name', 'VerAccionesAtender')->first();

        //PERMISO 9
        if (!Permission::where('name', 'AñadirEstrategiasAtender')->exists()) {
            Permission::create(['name' => 'AñadirEstrategiasAtender']);
        }

        $permission9 = Permission::where('name', 'AñadirEstrategiasAtender')->first();
        
        //PERMISO 10
        if (!Permission::where('name', 'AñadirAccionesAtender')->exists()) {
            Permission::create(['name' => 'AñadirAccionesAtender']);
        }

        $permission10 = Permission::where('name', 'AñadirAccionesAtender')->first();

        //PERMISO 11
        if (!Permission::where('name', 'EliminarEvidenciaAtender')->exists()) {
            Permission::create(['name' => 'EliminarEvidenciaAtender']);
        }

        $permission11 = Permission::where('name', 'EliminarEvidenciaAtender')->first();

        // PERMISO 12
        if (!Permission::where('name', 'VerEstrategiasSancionar')->exists()) {
            Permission::create(['name' => 'VerEstrategiasSancionar']);
        }

        $permission12 = Permission::where('name', 'VerEstrategiasSancionar')->first();

        // PERMISO 13
        if (!Permission::where('name', 'VerAccionesSancionar')->exists()) {
            Permission::create(['name' => 'VerAccionesSancionar']);
        }

        $permission13 = Permission::where('name', 'VerAccionesSancionar')->first();

        // PERMISO 14
        if (!Permission::where('name', 'AñadirEstrategiasSancionar')->exists()) {
            Permission::create(['name' => 'AñadirEstrategiasSancionar']);
        }

        $permission14 = Permission::where('name', 'AñadirEstrategiasSancionar')->first();

        // PERMISO 15
        if (!Permission::where('name', 'AñadirAccionesSancionar')->exists()) {
            Permission::create(['name' => 'AñadirAccionesSancionar']);
        }

        $permission15 = Permission::where('name', 'AñadirAccionesSancionar')->first();

        // PERMISO 16
        if (!Permission::where('name', 'EliminarEvidenciaSancionar')->exists()) {
            Permission::create(['name' => 'EliminarEvidenciaSancionar']);
        }

        $permission16 = Permission::where('name', 'EliminarEvidenciaSancionar')->first();

       // PERMISO 17
        if (!Permission::where('name', 'VerEstrategiasErradicar')->exists()) {
            Permission::create(['name' => 'VerEstrategiasErradicar']);
            }

        $permission17 = Permission::where('name', 'VerEstrategiasErradicar')->first();

        // PERMISO 18
        if (!Permission::where('name', 'VerAccionesErradicar')->exists()) {
            Permission::create(['name' => 'VerAccionesErradicar']);
        }

        $permission18 = Permission::where('name', 'VerAccionesErradicar')->first();

        // PERMISO 19
        if (!Permission::where('name', 'AñadirEstrategiasErradicar')->exists()) {
            Permission::create(['name' => 'AñadirEstrategiasErradicar']);
        }

        $permission19 = Permission::where('name', 'AñadirEstrategiasErradicar')->first();

        // PERMISO 20
        if (!Permission::where('name', 'AñadirAccionesErradicar')->exists()) {
            Permission::create(['name' => 'AñadirAccionesErradicar']);
        }

        $permission20 = Permission::where('name', 'AñadirAccionesErradicar')->first();

        // PERMISO 21
        if (!Permission::where('name', 'EliminarEvidenciaErradicar')->exists()) {
            Permission::create(['name' => 'EliminarEvidenciaErradicar']);
        }

        $permission21 = Permission::where('name', 'EliminarEvidenciaErradicar')->first();

        // PERMISO 22
        if (!Permission::where('name', 'AñadirIndicadorPrevenir')->exists()) {
            Permission::create(['name' => 'AñadirIndicadorPrevenir']);
        }
    
        $permission22 = Permission::where('name', 'AñadirIndicadorPrevenir')->first();

        // PERMISO 23
        if (!Permission::where('name', 'VerIndicadorPrevenir')->exists()) {
            Permission::create(['name' => 'VerIndicadorPrevenir']);
        }
    
        $permission23 = Permission::where('name', 'VerIndicadorPrevenir')->first();

        // PERMISO 24
        if (!Permission::where('name', 'VerFormulaPrevenir')->exists()) {
            Permission::create(['name' => 'VerFormulaPrevenir']);
        }
    
        $permission24 = Permission::where('name', 'VerFormulaPrevenir')->first();

        // PERMISO 25
        if (!Permission::where('name', 'EliminarCalculoPrevenir')->exists()) {
            Permission::create(['name' => 'EliminarCalculoPrevenir']);
        }
    
        $permission25 = Permission::where('name', 'EliminarCalculoPrevenir')->first();

        // PERMISO 26
        if (!Permission::where('name', 'AñadirIndicadorAtender')->exists()) {
            Permission::create(['name' => 'AñadirIndicadorAtender']);
        }

        $permission26 = Permission::where('name', 'AñadirIndicadorAtender')->first();

        // PERMISO 27
        if (!Permission::where('name', 'VerIndicadorAtender')->exists()) {
            Permission::create(['name' => 'VerIndicadorAtender']);
        }

        $permission27 = Permission::where('name', 'VerIndicadorAtender')->first();

        // PERMISO 28
        if (!Permission::where('name', 'VerFormulaAtender')->exists()) {
            Permission::create(['name' => 'VerFormulaAtender']);
        }

        $permission28 = Permission::where('name', 'VerFormulaAtender')->first();

        // PERMISO 29
        if (!Permission::where('name', 'EliminarCalculoAtender')->exists()) {
            Permission::create(['name' => 'EliminarCalculoAtender']);
        }

        $permission29 = Permission::where('name', 'EliminarCalculoAtender')->first();

        // PERMISO 30
        if (!Permission::where('name', 'AñadirIndicadorSancionar')->exists()) {
            Permission::create(['name' => 'AñadirIndicadorSancionar']);
        }

        $permission30 = Permission::where('name', 'AñadirIndicadorSancionar')->first();

        // PERMISO 31
        if (!Permission::where('name', 'VerIndicadorSancionar')->exists()) {
            Permission::create(['name' => 'VerIndicadorSancionar']);
        }

        $permission31 = Permission::where('name', 'VerIndicadorSancionar')->first();

        // PERMISO 32
        if (!Permission::where('name', 'VerFormulaSancionar')->exists()) {
            Permission::create(['name' => 'VerFormulaSancionar']);
        }

        $permission32 = Permission::where('name', 'VerFormulaSancionar')->first();

        // PERMISO 33
        if (!Permission::where('name', 'EliminarCalculoSancionar')->exists()) {
            Permission::create(['name' => 'EliminarCalculoSancionar']);
        }

        $permission33 = Permission::where('name', 'EliminarCalculoSancionar')->first();

        // PERMISO 34
        if (!Permission::where('name', 'AñadirIndicadorErradicar')->exists()) {
            Permission::create(['name' => 'AñadirIndicadorErradicar']);
        }

        $permission34 = Permission::where('name', 'AñadirIndicadorErradicar')->first();

        // PERMISO 35
        if (!Permission::where('name', 'VerIndicadorErradicar')->exists()) {
            Permission::create(['name' => 'VerIndicadorErradicar']);
        }

        $permission35 = Permission::where('name', 'VerIndicadorErradicar')->first();

        // PERMISO 36
        if (!Permission::where('name', 'VerFormulaErradicar')->exists()) {
            Permission::create(['name' => 'VerFormulaErradicar']);
        }

        $permission36 = Permission::where('name', 'VerFormulaErradicar')->first();

        // PERMISO 37
        if (!Permission::where('name', 'EliminarCalculoErradicar')->exists()) {
            Permission::create(['name' => 'EliminarCalculoErradicar']);
        }

        $permission37 = Permission::where('name', 'EliminarCalculoErradicar')->first();


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

        //DAR PERMISO 7
        if ($role1 && !$role1->hasPermissionTo($permission7)) {
            $role1->givePermissionTo($permission7);
        }

        //DAR PERMISO 8
        if ($role1 && !$role1->hasPermissionTo($permission8)) {
            $role1->givePermissionTo($permission8);
        }

        //DAR PERMISO 9
        if ($role1 && !$role1->hasPermissionTo($permission9)) {
            $role1->givePermissionTo($permission9);
        }

        //DAR PERMISO 10
        if ($role1 && !$role1->hasPermissionTo($permission10)) {
            $role1->givePermissionTo($permission10);
        }

        // DAR PERMISO 11
        if ($role1 && !$role1->hasPermissionTo($permission11)) {
            $role1->givePermissionTo($permission11);
        }

        // DAR PERMISO 12
        if ($role1 && !$role1->hasPermissionTo($permission12)) {
            $role1->givePermissionTo($permission12);
        }

        // DAR PERMISO 13
        if ($role1 && !$role1->hasPermissionTo($permission13)) {
            $role1->givePermissionTo($permission13);
        }

        // DAR PERMISO 14
        if ($role1 && !$role1->hasPermissionTo($permission14)) {
            $role1->givePermissionTo($permission14);
        }

        // DAR PERMISO 15
        if ($role1 && !$role1->hasPermissionTo($permission15)) {
            $role1->givePermissionTo($permission15);
        }

        // DAR PERMISO 16
        if ($role1 && !$role1->hasPermissionTo($permission16)) {
            $role1->givePermissionTo($permission16);
        }

        // DAR PERMISO 17
        if ($role1 && !$role1->hasPermissionTo($permission17)) {
            $role1->givePermissionTo($permission17);
        }

        // DAR PERMISO 18
        if ($role1 && !$role1->hasPermissionTo($permission18)) {
            $role1->givePermissionTo($permission18);
        }

        // DAR PERMISO 19
        if ($role1 && !$role1->hasPermissionTo($permission19)) {
            $role1->givePermissionTo($permission19);
        }

        // DAR PERMISO 20
        if ($role1 && !$role1->hasPermissionTo($permission20)) {
            $role1->givePermissionTo($permission20);
        }

        // DAR PERMISO 21
        if ($role1 && !$role1->hasPermissionTo($permission21)) {
            $role1->givePermissionTo($permission21);
        }

        // DAR PERMISO 22
        if ($role1 && !$role1->hasPermissionTo($permission22)) {
            $role1->givePermissionTo($permission22);
        }

        // DAR PERMISO 23
        if ($role1 && !$role1->hasPermissionTo($permission23)) {
            $role1->givePermissionTo($permission23);
        }

        // DAR PERMISO 24
        if ($role1 && !$role1->hasPermissionTo($permission24)) {
            $role1->givePermissionTo($permission24);
        }

        // DAR PERMISO 25
        if ($role1 && !$role1->hasPermissionTo($permission25)) {
            $role1->givePermissionTo($permission25);
        }

        // DAR PERMISO 26
        if ($role1 && !$role1->hasPermissionTo($permission26)) {
            $role1->givePermissionTo($permission26);
        }

        // DAR PERMISO 27
        if ($role1 && !$role1->hasPermissionTo($permission27)) {
            $role1->givePermissionTo($permission27);
        }

        // DAR PERMISO 28
        if ($role1 && !$role1->hasPermissionTo($permission28)) {
            $role1->givePermissionTo($permission28);
        }

        // DAR PERMISO 29
        if ($role1 && !$role1->hasPermissionTo($permission29)) {
            $role1->givePermissionTo($permission29);
        }

        // DAR PERMISO 30
        if ($role1 && !$role1->hasPermissionTo($permission30)) {
            $role1->givePermissionTo($permission30);
        }

        // DAR PERMISO 31
        if ($role1 && !$role1->hasPermissionTo($permission31)) {
            $role1->givePermissionTo($permission31);
        }

        // DAR PERMISO 32
        if ($role1 && !$role1->hasPermissionTo($permission32)) {
            $role1->givePermissionTo($permission32);
        }

        // DAR PERMISO 33
        if ($role1 && !$role1->hasPermissionTo($permission33)) {
            $role1->givePermissionTo($permission33);
        }

        // DAR PERMISO 34
        if ($role1 && !$role1->hasPermissionTo($permission34)) {
            $role1->givePermissionTo($permission34);
        }

        // DAR PERMISO 35
        if ($role1 && !$role1->hasPermissionTo($permission35)) {
            $role1->givePermissionTo($permission35);
        }

        // DAR PERMISO 36
        if ($role1 && !$role1->hasPermissionTo($permission36)) {
            $role1->givePermissionTo($permission36);
        }

        // DAR PERMISO 37
        if ($role1 && !$role1->hasPermissionTo($permission37)) {
            $role1->givePermissionTo($permission37);
        }
    }
}
