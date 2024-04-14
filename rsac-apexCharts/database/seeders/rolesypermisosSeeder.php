<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class rolesypermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $roles = [
            'Automotriz',
            'Automotriz-registrar',
            'Automotriz-eliminar',

            'Manufactura',
            'Manufactura-registrar',
            'Manufactura-eliminar',

            'Redes',
            'Redes-registrar',
            'Redes-eliminar',

            'LAGE',
            'LAGE-registrar',
            'LAGE-eliminar',

            'Mecatronica',
            'Mecatronica-registrar',
            'Mecatronica-eliminar',

            'Negocios',
            'Negocios-registrar',
            'Negocios-eliminar',

            'Posgrado',
            'Posgrado-registrar',
            'Posgrado-eliminar',

            'Sistemas',
            'Sistemas-registrar',
            'Sistemas-eliminar',
            
            'Coordinacion',
            'Coordinacion-registrar',
            'Coordinacion-eliminar',

            'Resumen',
            'Resumen-registrar',
            'Resumen-eliminar',

            'Rector',
            'SecretarioAcademico',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        
    }
}
