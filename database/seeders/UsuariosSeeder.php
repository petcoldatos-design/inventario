<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'usuario' => 'admin',
            'name' => 'Administrador',
            'email' => 'admin@plastypetco.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
            'activo' => true,
        ]);

        User::create([
            'usuario' => 'inventario',
            'name' => 'Carlos Inventario',
            'email' => 'inventario@plastypetco.com',
            'password' => Hash::make('inventario123'),
            'rol' => 'inventario',
            'activo' => true,
        ]);

        User::create([
            'usuario' => 'procesos',
            'name' => 'Maria Procesos',
            'email' => 'procesos@plastypetco.com',
            'password' => Hash::make('procesos123'),
            'rol' => 'procesos',
            'activo' => true,
        ]);

        User::create([
            'usuario' => 'despachos',
            'name' => 'Juan Despachos',
            'email' => 'despachos@plastypetco.com',
            'password' => Hash::make('despachos123'),
            'rol' => 'despachos',
            'activo' => true,
        ]);
    }
}