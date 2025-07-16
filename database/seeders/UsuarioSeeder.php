<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario 
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'daniel.asencio.ortiz@hotmail.com'],
            [
                'name' => 'Daniel Asencio',
                'password' => bcrypt('nsyydkhw'),
            ]
        );

        // Asignar rol Admin
        $user->assignRole('admin');
    }
}
