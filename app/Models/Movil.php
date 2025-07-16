<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movil extends Model
{
    use HasFactory;

    protected $table = 'movils';

    protected $fillable = [
        'marca',
        'placa',
        'estado',
    ];
}
