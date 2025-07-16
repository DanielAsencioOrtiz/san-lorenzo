<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoConcreto extends Model
{
    use HasFactory;
    
    protected $table = 'tipo_concretos';

    protected $fillable = [
        'nombre_tipo',
        'estado',
    ];
}
