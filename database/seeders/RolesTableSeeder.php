<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $adminRole = Role::create([
            'name' => 'Administrador',
            'slug' => 'admin',
        ]);
        
        $vendedorRole = Role::create([
            'name' => 'Vendedor',
            'slug' => 'vendedor',
        ]);
        
        // Crear un usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Crear un usuario vendedor
        $vendedor = User::create([
            'name' => 'Vendedor',
            'email' => 'vendedor@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Asignar roles
        $admin->roles()->attach($adminRole);
        $vendedor->roles()->attach($vendedorRole);
    }
}