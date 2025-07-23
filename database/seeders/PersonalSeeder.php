<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personal;
use App\Models\TipoPersonal;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PersonalSeeder extends Seeder
{
    public function run()
    {
        $tipos = TipoPersonal::pluck('id')->toArray(); // IDs de los tipos de personal
        $usedDocuments = [];

        for ($i = 1; $i <= 20; $i++) {
            // Generar un nro_documento único (8 dígitos)
            do {
                $nro_documento = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            } while (in_array($nro_documento, $usedDocuments));

            $usedDocuments[] = $nro_documento;

            Personal::create([
                'nro_documento'    => $nro_documento,
                'id_documento'     => 1,
                'nombres'          => 'Nombre ' . $i,
                'apellidos'        => 'Apellido ' . $i,
                'telefono'         => '9' . rand(10000000, 99999999),
                'id_tipo_personal' => $tipos[array_rand($tipos)],
                'brevete'          => Str::upper(Str::random(6)),
                'fecha_ingreso'    => Carbon::now()->subDays(rand(1, 100)),
            ]);
        }
    }
}
