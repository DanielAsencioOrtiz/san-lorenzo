<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    protected $table = 'provincias';

    protected $fillable = [
        'id',
        'provincia',
        'id_departamento'
    ];

    public function departamento(){
        return $this->belongsTo(Departamento::class,'id_departamento');
    }
}
