<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamentos')->insert([
            ['departamento' => 'Amazonas'],
            ['departamento' => 'Áncash'],
            ['departamento' => 'Apurímac'],
            ['departamento' => 'Arequipa'],
            ['departamento' => 'Ayacucho'],
            ['departamento' => 'Cajamarca'],
            ['departamento' => 'Callao'],
            ['departamento' => 'Cusco'],
            ['departamento' => 'Huancavelica'],
            ['departamento' => 'Huánuco'],
            ['departamento' => 'Ica'],
            ['departamento' => 'Junín'],
            ['departamento' => 'La Libertad'],
            ['departamento' => 'Lambayeque'],
            ['departamento' => 'Lima'],
            ['departamento' => 'Loreto'],
            ['departamento' => 'Madre de Dios'],
            ['departamento' => 'Moquegua'],
            ['departamento' => 'Pasco'],
            ['departamento' => 'Piura'],
            ['departamento' => 'Puno'],
            ['departamento' => 'San Martín'],
            ['departamento' => 'Tacna'],
            ['departamento' => 'Tumbes'],
            ['departamento' => 'Ucayali']
        ]);
    }
}
