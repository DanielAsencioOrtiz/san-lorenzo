<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Piedra;

class PiedraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $piedras = [
            ['nombre_piedra' => 'H67', 'estado' => 1],
            ['nombre_piedra' => 'H8', 'estado' => 1],
        ];

        foreach ($piedras as $piedra) {
            Piedra::create($piedra);
        }
    }
}
