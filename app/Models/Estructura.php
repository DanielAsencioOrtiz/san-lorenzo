<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estructura extends Model
{
    use HasFactory;
    
    protected $table = 'estructuras';

    protected $fillable = [
        'nombre_estructura',
        'estado',
    ];
}
