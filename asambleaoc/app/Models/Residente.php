<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residente extends Model
{
    use HasFactory;

    protected $table = 'residentes';

    protected $fillable = [
        'nombre',
        'tipo',
        'apto',
        'coeficiente',
        'captura',
        'photo',
    ];

    public function votaciones()
    {
        return $this->hasMany(Votacion::class, 'residente_id');
    }
}
