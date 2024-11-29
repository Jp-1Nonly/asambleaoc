<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votacion extends Model
{
    use HasFactory;
    protected $fillable = ['opcion_id', 'residente_id', 'fecha_voto'];

    public function opcion()
    {
        return $this->belongsTo(Opcion::class);
    }

    public function residente()
    {
        return $this->belongsTo(Residente::class);
    }
}
