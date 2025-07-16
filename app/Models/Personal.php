<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personals';

    protected $fillable = [
        'nro_documento',
        'id_documento',
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'direccion',
        'id_tipo_personal',
        'estado',
    ];

    // Relaciones
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_documento');
    }

    public function tipoPersonal()
    {
        return $this->belongsTo(TipoPersonal::class, 'id_tipo_personal');
    }
}
