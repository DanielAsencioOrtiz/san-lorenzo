<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sede;

class SedeSeeder extends Seeder
{
    public function run()
    {
        $sedes = [
            ['nombre_sede' => 'TRUJILLO', 'estado' => 1],
            ['nombre_sede' => 'CHEPEN', 'estado' => 1],
            ['nombre_sede' => 'TODAS', 'estado' => 1],
        ];

        foreach ($sedes as $sede) {
            Sede::create($sede);
        }
    }
}
