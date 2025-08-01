<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPersonal extends Model
{
    use HasFactory;
    
    protected $table = 'tipo_personals';

    protected $fillable = [
        'nombre_tipo',
        'estado',
    ];
}
