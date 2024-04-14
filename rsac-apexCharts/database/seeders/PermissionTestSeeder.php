<?php

namespace Database\Seeders;

// database/seeders/PermissionTestSeeder.php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionTestSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Nombre fake2',
            'email' => 'fake@fake.com',
            'password' => bcrypt('fake'),
        ]);

        if ($user) {
            // Asignar el permiso "Automotriz-agregar" al usuario
            // Asignar los dos roles al usuario
            $user->assignRole(['Automotriz', 'Automotriz-registrar']);

        } else {
            echo "El usuario con el correo electrónico 'admin@rsac.com' no se encontró.";
        }

    }
}

