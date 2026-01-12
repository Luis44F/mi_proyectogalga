<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ADMINISTRADOR GENERAL → TODO
        $admin = Role::where('nombre', 'Administrador General')->first();
        $admin->permissions()->sync(Permission::all());

        // SUPERVISOR GENERAL
        $supervisor = Role::where('nombre', 'Supervisor General de Producción')->first();
        $supervisor->permissions()->sync([
            Permission::where('nombre', 'ver_papeletas')->first()->id,
            Permission::where('nombre', 'ver_produccion')->first()->id,
            Permission::where('nombre', 'autorizar_fase')->first()->id,
            Permission::where('nombre', 'ver_dashboard')->first()->id,
        ]);

        // OPERADOR TEJEDORA
        $tejedora = Role::where('nombre', 'Operador de Tejedora')->first();
        $tejedora->permissions()->sync([
            Permission::where('nombre', 'crear_papeletas')->first()->id,
            Permission::where('nombre', 'ver_papeletas')->first()->id,
        ]);

        // DISEÑO
        $disenador = Role::where('nombre', 'Diseñador')->first();
        $disenador->permissions()->sync([
            Permission::where('nombre', 'ver_ficha_tecnica')->first()->id,
            Permission::where('nombre', 'editar_ficha_tecnica')->first()->id,
        ]);
    }
}
