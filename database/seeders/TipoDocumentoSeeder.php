<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentos = [
            [
                'nombre_documento' => 'DNI',
                'mostrar_cliente' => true,
                'mostrar_personal' => true,
                'estado' => 1,
            ],
            [
                'nombre_documento' => 'RUC',
                'mostrar_cliente' => true,
                'mostrar_personal' => true,
                'estado' => 1,
            ],
        ];

        foreach ($documentos as $documento) {
            TipoDocumento::create($documento);
        }
    }
}
