<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movil;

class MovilSeeder extends Seeder
{
    public function run()
    {
        $moviles = [
            [
                'descripcion' => 'MIXER FOTON',
                'modelo' => 'BJ5259GJB00-AA',
                'placa' => 'BZM 713',
                'serie' => 'LVBV6PEBXRT501127',
                'forms' => 'CAMION MIXER FOTON - PLACA BZM 713',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER FOTON',
                'modelo' => 'BJ5319GJB-AF',
                'placa' => 'BZL 893',
                'serie' => 'LVBV7PEC4RT051934',
                'forms' => 'CAMION MIXER FOTON - PLACA BZL 893',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER SCANIA',
                'modelo' => 'P420 B6X4',
                'placa' => 'D3A 854',
                'serie' => '9BSP6X400C3694407',
                'forms' => 'CAMION MIXER SCANIA - PLACA D3A 854',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER SHACMAN',
                'modelo' => 'SX5258GJB6R384C',
                'placa' => 'CCS 877',
                'serie' => 'LZGJL4R48RX082243',
                'forms' => 'CAMION MIXER SHACMAN - PLACA CCS 877',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER SHACMAN',
                'modelo' => 'SX5258GJB6R384C',
                'placa' => 'CCT 739',
                'serie' => 'LZGJL4R46RX082242',
                'forms' => 'CAMION MIXER SHACMAN - PLACA CCT 739',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER SHACMAN',
                'modelo' => 'SX5258GJB6R384C',
                'placa' => 'TFG 821',
                'serie' => 'LZGJL4R40SX003900',
                'forms' => 'NUEVO CAMION MIXER SHACMAN - PLACA 970',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER SHACMAN',
                'modelo' => 'SX5258GJB6R384C',
                'placa' => 'TFG 825',
                'serie' => 'LZGJL4R48SX003899',
                'forms' => 'NUEVO CAMION MIXER SHACMAN - PLACA EP258',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER ZOOMLION',
                'modelo' => 'DFL5251GJBA4',
                'placa' => 'CAF 728',
                'serie' => 'LGAX4DS34R9845523',
                'forms' => 'CAMION MIXER DONG FEN - PLACA CAF 728',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER ZOOMLION',
                'modelo' => 'DFL5251GJBA4',
                'placa' => 'CAE 876',
                'serie' => 'LGAX4DS3XR9843985',
                'forms' => 'CAMION MIXER DONG FEN - PLACA CAE 876',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER ZOOMLION',
                'modelo' => 'DFL5251GJBA4',
                'placa' => 'CAE 899',
                'serie' => 'LGAX4DS32R9845522',
                'forms' => 'CAMION MIXER DONG FEN - PLACA CAE 899',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER ZOOMLION',
                'modelo' => 'ZZ1317N306GE1',
                'placa' => 'S/P',
                'serie' => 'LZZPBXNEXSJ393265',
                'forms' => 'CAMION MIXER ZOOMLION 1 - S/P',
                'estado' => 1,
            ],
            [
                'descripcion' => 'MIXER ZOOMLION',
                'modelo' => 'ZZ1317N306GE1',
                'placa' => 'S/P',
                'serie' => 'LZZPBXNE6SJ393280',
                'forms' => 'CAMION MIXER ZOOMLION 2 - S/P',
                'estado' => 1,
            ],
            [
                'descripcion' => 'BOMBA CONCRETO SINOTRUK',
                'modelo' => 'ZZ5357TXFV464ME1',
                'placa' => 'CBD 944',
                'serie' => 'LZZ1BMVF8PN042870',
                'forms' => 'BOMBA DE CONCRETO HOWO PLACA - CBD 944',
                'estado' => 1,
            ],
            [
                'descripcion' => 'BOMBA CONCRETO ZOOMLION',
                'modelo' => 'ZZ5357TXFV464ME1',
                'placa' => 'CDQ 850',
                'serie' => 'LZZ1BMVF4RD232691',
                'forms' => 'BOMBA DE CONCRETO ZOOMLION CDQ 850',
                'estado' => 1,
            ],
            [
                'descripcion' => 'BOMBA CONCRETO SINOTRUK',
                'modelo' => 'ZZ5337THBN464GE1',
                'placa' => 'S/P',
                'serie' => 'LZZ1BMNFXNW964399',
                'forms' => 'BOMBA DE CONCRETO SINOTRUK TX350',
                'estado' => 1,
            ],
            [
                'descripcion' => 'BOMBA ESTACIONARIA SINOTRUK',
                'modelo' => 'ZZ1167K501GE1',
                'placa' => 'S/P',
                'serie' => 'LZZ1BBHF2SN345362',
                'forms' => 'BOMBA ESTACIONARIA SOBRE CAMION SINOTRUK',
                'estado' => 1,
            ],
            [
                'descripcion' => 'CARGADOR FRONTAL JBC 436ZX',
                'modelo' => 'BC 436ZX',
                'placa' => 'S/P',
                'serie' => 'Jcb43070E01305975',
                'forms' => 'CARGADOR FRONTAL JBC PLACA JBC-436',
                'estado' => 1,
            ],
            [
                'descripcion' => 'CARGADOR FRONTAL VOLVO - L110H',
                'modelo' => 'VOLVO L110H',
                'placa' => 'S/P',
                'serie' => 'VCEL110HTE0010202',
                'forms' => 'CARGADOR FRONTAL VOLVO PLACA  VOL-110',
                'estado' => 1,
            ],
        ];

        foreach ($moviles as $movil) {
            Movil::create($movil);
        }
    }
}
