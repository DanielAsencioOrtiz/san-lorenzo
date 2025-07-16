<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDespacho extends Model
{
    use HasFactory;

    protected $table = 'personal_despachos';

    protected $fillable = [
        'id_programa_despacho',
        'id_personal',
    ];

    // Relaciones
    public function programaDespacho()
    {
        return $this->belongsTo(ProgramaDespacho::class, 'id_programa_despacho');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal');
    }
}
