<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'pregunta', 'estado', // Incluir el campo 'estado' en fillable
    ];


// Modelo Pregunta
public function opciones()
{
    
    return $this->hasMany(Opcion::class, 'pregunta_id');
}



    
}
