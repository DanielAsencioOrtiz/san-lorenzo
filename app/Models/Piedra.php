<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piedra extends Model
{
    use HasFactory;

     protected $table = 'piedras';

    protected $fillable = [
        'nombre_piedra',
        'estado',
    ];

}
