<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcionesTable extends Migration
{
    public function up()
{
    Schema::create('opciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pregunta_id')->constrained()->onDelete('cascade');
        $table->string('opcion');
        $table->integer('votos')->default(0);
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('opciones');
    }
}

