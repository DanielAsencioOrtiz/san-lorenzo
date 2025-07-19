<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resistencia;

class ResistenciaSeeder extends Seeder
{
    public function run()
    {
        $resistencias = [
            ['nombre_resistencia' => '01:10', 'estado' => 1],
            ['nombre_resistencia' => '01:50', 'estado' => 1],
            ['nombre_resistencia' => '100', 'estado' => 1],
            ['nombre_resistencia' => '140', 'estado' => 1],
            ['nombre_resistencia' => '175', 'estado' => 1],
            ['nombre_resistencia' => '210', 'estado' => 1],
            ['nombre_resistencia' => '245', 'estado' => 1],
            ['nombre_resistencia' => '280', 'estado' => 1],
            ['nombre_resistencia' => '350', 'estado' => 1],
            ['nombre_resistencia' => '420', 'estado' => 1],
        ];

        foreach ($resistencias as $resistencia) {
            Resistencia::create($resistencia);
        }
    }
}
