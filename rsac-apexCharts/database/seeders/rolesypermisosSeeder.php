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
            'Automotriz-editar',

            'Manufactura',
            'Manufactura-registrar',
            'Manufactura-eliminar',
            'Manufactura-editar',

            'Redes',
            'Redes-registrar',
            'Redes-eliminar',
            'Redes-editar',

            'LAGE',
            'LAGE-registrar',
            'LAGE-eliminar',
            'LAGE-editar',

            'Mecatronica',
            'Mecatronica-registrar',
            'Mecatronica-eliminar',
            'Mecatronica-editar',

            'Negocios',
            'Negocios-registrar',
            'Negocios-eliminar',
            'Negocios-editar',

            'Posgrado',
            'Posgrado-registrar',
            'Posgrado-eliminar',
            'Posgrado-editar',

            'Sistemas',
            'Sistemas-registrar',
            'Sistemas-eliminar',
            'Sistemas-editar',
            
            'Coordinacion',
            'Coordinacion-registrar',
            'Coordinacion-eliminar',
            'Coordinacion-editar',

            'Resumen',
            'Resumen-registrar',
            'Resumen-eliminar',
            'Resumen-editar',

            'Rector',
            'SecretarioAcademico',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        
    }
}
