<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCemento extends Model
{
    use HasFactory;
    
    protected $table = 'tipo_cementos';

    protected $fillable = [
        'nombre_tipo',
        'estado',
    ];
}
