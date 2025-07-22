<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cantera extends Model
{
    use HasFactory;

    protected $table = 'canteras';

    protected $fillable = [
        'nombre_cantera',
        'estado',
    ];
}
