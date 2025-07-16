<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;
    
    protected $table = 'provincias';

    protected $fillable = [
        'provincia',
        'id_departamento'
    ];

    public function departamento(){
        return $this->belongsTo(Departamento::class,'id_departamento');
    }
}
