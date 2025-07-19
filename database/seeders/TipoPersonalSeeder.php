<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoPersonal;

class TipoPersonalSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            ['nombre_tipo' => 'OPERADOR DE MIXER', 'estado' => 1],
            ['nombre_tipo' => 'CONDUCTOR DE MIXER', 'estado' => 1],
            ['nombre_tipo' => 'OPERADOR DE MIXER Y VOLQUETE', 'estado' => 1],
            ['nombre_tipo' => 'OPERADOR DE CARGADOR FRONTAL', 'estado' => 1],
            ['nombre_tipo' => 'OPERADOR MULTIPLE', 'estado' => 1],
            ['nombre_tipo' => 'OPERADOR DE PLANTA', 'estado' => 1],
            ['nombre_tipo' => 'AYUDANTE DE PLANTA', 'estado' => 1],
            ['nombre_tipo' => 'AYUDANTE DE BOMBA', 'estado' => 1],
            ['nombre_tipo' => 'OPERADOR CARGADOR FRONTAL', 'estado' => 1],
            ['nombre_tipo' => 'OPERADOR DE PLUMA', 'estado' => 1],
            ['nombre_tipo' => 'AYUDANTE DE PLUMA', 'estado' => 1],
            ['nombre_tipo' => 'AYUDANTE MULTIPLE', 'estado' => 1],
        ];

        foreach ($tipos as $tipo) {
            TipoPersonal::create($tipo);
        }
    }
}
