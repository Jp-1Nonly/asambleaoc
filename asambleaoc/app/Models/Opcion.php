<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; // Cambia esto si no es 'id'
    protected $table = 'opciones';
    protected $fillable = ['pregunta_id', 'opcion', 'estado', 'votos'];

    // Modelo Opcion
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }
    

}
