<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoColocacion extends Model
{
    use HasFactory;

    protected $table = 'metodo_colocacions';

    protected $fillable = [
        'nombre_metodo',
        'estado',
    ];
}
