<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Secretaria de las Mujeres',
            'email' => 'semujer@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Administrador');
    }
}