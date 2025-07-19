<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoCemento;

class TipoCementoSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            ['nombre_tipo' => 'MS', 'estado' => 1],
            ['nombre_tipo' => 'I', 'estado' => 1],
            ['nombre_tipo' => 'V', 'estado' => 1],
        ];

        foreach ($tipos as $tipo) {
            TipoCemento::create($tipo);
        }
    }
}
