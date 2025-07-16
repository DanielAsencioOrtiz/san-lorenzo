<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDespacho extends Model
{
    use HasFactory;

    protected $table = 'detalle_despachos';

    protected $fillable = [
        'id_programa_despacho',
        'id_tipo_concreto',
        'id_metodo_colocacion',
        'id_bomba',
        'id_tipo_cemento',
        'id_estructura',
        'id_cliente',
        'id_obra',
        'metros_cubicos',
        'pulgadas',
        'hora_despacho',
    ];

    // Relaciones
    public function programaDespacho()
    {
        return $this->belongsTo(ProgramaDespacho::class, 'id_programa_despacho');
    }

    public function tipoConcreto()
    {
        return $this->belongsTo(TipoConcreto::class, 'id_tipo_concreto');
    }

    public function metodoColocacion()
    {
        return $this->belongsTo(MetodoColocacion::class, 'id_metodo_colocacion');
    }

    public function bomba()
    {
        return $this->belongsTo(Bomba::class, 'id_bomba');
    }

    public function tipoCemento()
    {
        return $this->belongsTo(TipoCemento::class, 'id_tipo_cemento');
    }

    public function estructura()
    {
        return $this->belongsTo(Estructura::class, 'id_estructura');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function obra()
    {
        return $this->belongsTo(Obra::class, 'id_obra');
    }
}
