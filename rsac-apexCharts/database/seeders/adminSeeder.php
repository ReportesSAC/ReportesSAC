<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // crear roles 'Administrador' y 'Automotriz'
       $role1 = Role::create(['name' => 'Administrador']);

       // crear un usuario
         $user = User::create([
              'name' => 'Administrador RSAC',
              'email' => 'admin@rsac.com',
              'password' => bcrypt('upq1234'),
         ]);

       // darle el role1 al usuario con id 1
       $user = User::find(1);
       $user->assignRole($role1);  
    }
}
