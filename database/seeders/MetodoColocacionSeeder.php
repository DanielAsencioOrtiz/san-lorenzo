<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetodoColocacion;

class MetodoColocacionSeeder extends Seeder
{
    public function run()
    {
        $metodos = [
            ['nombre_metodo' => 'BOMBA ESTACIONARIA', 'estado' => 1],
            ['nombre_metodo' => 'BOMBA HORMIGONERA', 'estado' => 1],
            ['nombre_metodo' => 'DIRECTO', 'estado' => 1],
            ['nombre_metodo' => 'GRUA', 'estado' => 1],
        ];

        foreach ($metodos as $metodo) {
            MetodoColocacion::create($metodo);
        }
    }
}
