<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estructura;

class EstructuraSeeder extends Seeder
{
    public function run()
    {
        $estructuras = [
            ['nombre_estructura' => 'MURO', 'estado' => 1],
            ['nombre_estructura' => 'SOBRE CIMENTO', 'estado' => 1],
            ['nombre_estructura' => 'LOSA ALIGERADA', 'estado' => 1],
            ['nombre_estructura' => 'PLACAS', 'estado' => 1],
            ['nombre_estructura' => 'SARDINELES', 'estado' => 1],
            ['nombre_estructura' => 'SOBRE LOSA', 'estado' => 1],
            ['nombre_estructura' => 'PISO', 'estado' => 1],
            ['nombre_estructura' => 'PAVIMENTOS', 'estado' => 1],
            ['nombre_estructura' => 'VERTICALES', 'estado' => 1],
            ['nombre_estructura' => 'LOSA Y RAMPA', 'estado' => 1],
            ['nombre_estructura' => 'SOLADO', 'estado' => 1],
            ['nombre_estructura' => 'PLATEA DE CIMENTACION', 'estado' => 1],
            ['nombre_estructura' => 'MURO ANCLADO', 'estado' => 1],
            ['nombre_estructura' => 'VIGA', 'estado' => 1],
            ['nombre_estructura' => 'FALSO PISO', 'estado' => 1],
            ['nombre_estructura' => 'PLACAS Y COLUMNAS', 'estado' => 1],
            ['nombre_estructura' => 'ZAPATA', 'estado' => 1],
            ['nombre_estructura' => 'ZOLADO', 'estado' => 1],
            ['nombre_estructura' => 'VEREDA', 'estado' => 1],
        ];

        foreach ($estructuras as $estructura) {
            Estructura::create($estructura);
        }
    }
}
