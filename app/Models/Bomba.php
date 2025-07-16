<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bomba extends Model
{
    use HasFactory;
    
    protected $table = 'bombas';

    protected $fillable = [
        'nombre_bomba',
        'estado',
    ];
}
