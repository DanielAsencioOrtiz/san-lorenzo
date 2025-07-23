<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaDespacho extends Model
{
    use HasFactory;

    protected $table = 'programa_despachos';

    protected $fillable = [
        'fecha_programa',
        'id_sede',
        'total_m3',
        'hora_entrada_personal',
        'estado',
    ];

    // Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'id_sede');
    }

    public function personalDespacho()
    {
        return $this->belongsToMany(Personal::class, 'personal_despachos', 'id_programa_despacho', 'id_personal');
    }
}
