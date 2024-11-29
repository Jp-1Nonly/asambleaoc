<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    use HasFactory;

    protected $table = 'opciones';
    protected $fillable = ['pregunta_id', 'opcion', 'votos'];

    // app/Models/Opcion.php

public function pregunta()
{
    return $this->belongsTo(Pregunta::class);
}

}
