<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotacionesTable extends Migration
{
    public function up()
    {
        Schema::create('votaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_pregunta');
            $table->unsignedBigInteger('id_opcion');
            $table->timestamps();
        
            // Llaves foráneas
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_pregunta')->references('id')->on('preguntas')->onDelete('cascade');
            $table->foreign('id_opcion')->references('id')->on('opciones')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('votaciones');
    }
}
