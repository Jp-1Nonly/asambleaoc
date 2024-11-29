<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request; 
use App\Models\Pregunta;    


class CreatePreguntasTable extends Migration
{
    public function up()
{
    Schema::table('preguntas', function (Blueprint $table) {
        // Cambiar la columna estado a ENUM('Activo', 'Inactivo')
        $table->enum('estado', ['Activa', 'Inactiva'])->default('Activa')->change();
    });
}

public function down()
{
    Schema::table('preguntas', function (Blueprint $table) {
        // Revertir la columna a su tipo anterior si es necesario
        $table->string('estado')->change();
    });
}



}

