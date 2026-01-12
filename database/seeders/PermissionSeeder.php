<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // 📄 Papeletas
            'ver_papeletas',
            'crear_papeletas',
            'editar_papeletas',

            // 🧵 Producción
            'ver_produccion',
            'registrar_flujo',
            'autorizar_fase',

            // 📐 Diseño / Patronaje
            'ver_ficha_tecnica',
            'editar_ficha_tecnica',
            'subir_patrones',

            // 📦 Distribución
            'ver_distribucion',
            'cerrar_pedido',

            // 💬 Mensajería
            'usar_mensajeria',

            // ⚙️ Administración
            'ver_dashboard',
            'gestionar_usuarios',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'nombre' => $permission
            ]);
        }
    }
}
