<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Diseñador',
            'Patronista',
            'Programador de Tejido',
            'Operador de Tejedora',
            'Supervisor de Tejedora',
            'Operario de Hilvanado',
            'Operario de Planchado',
            'Operario de Corte',
            'Confeccionista',
            'Operario de Deshilado',
            'Planchador Final',
            'Técnico de Calidad',
            'Personal de Embalaje',
            'Auxiliar de Conteo Final',
            'Logística / Distribución',
            'Supervisor General de Producción',
            'Administrador General',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'nombre' => $role
            ]);
        }
    }
}
