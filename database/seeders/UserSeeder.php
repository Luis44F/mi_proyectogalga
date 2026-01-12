<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ============================
        // ADMINISTRADOR GENERAL
        // ============================
        $admin = User::create([
            'nombre_completo' => 'Administrador General',
            'email' => 'admin@galga.com',
            'password' => Hash::make('admin123'),
            'telefono' => '0000000000',
        ]);

        $adminRole = Role::where('nombre', 'Administrador General')->first();
        $admin->roles()->attach($adminRole->id);

        // ============================
        // TEJEDORA
        // ============================
        $tejedora = User::create([
            'nombre_completo' => 'Operador Tejedora',
            'email' => 'tejedora@galga.com',
            'password' => Hash::make('tejedora123'),
            'telefono' => '1111111111',
        ]);

        $tejedoraRole = Role::where('nombre', 'Operador de Tejedora')->first();
        $tejedora->roles()->attach($tejedoraRole->id);

        // ============================
        // SUPERVISOR GENERAL
        // ============================
        $supervisor = User::create([
            'nombre_completo' => 'Supervisor General',
            'email' => 'supervisor@galga.com',
            'password' => Hash::make('supervisor123'),
            'telefono' => '2222222222',
        ]);

        $supervisorRole = Role::where('nombre', 'Supervisor General de Producción')->first();
        $supervisor->roles()->attach($supervisorRole->id);
    }
}
