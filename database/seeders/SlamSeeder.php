<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slam;

class SlamSeeder extends Seeder
{
    public function run()
    {
        $slams = [
            ['nombre_slam' => 'A-"5', 'estado' => 1],
            ['nombre_slam' => 'A-"4-"6', 'estado' => 1],
            ['nombre_slam' => 'A-"6', 'estado' => 1],
            ['nombre_slam' => 'A-"6-"8', 'estado' => 1],
            ['nombre_slam' => 'A-"7', 'estado' => 1],
        ];

        foreach ($slams as $slam) {
            Slam::create($slam);
        }
    }
}
