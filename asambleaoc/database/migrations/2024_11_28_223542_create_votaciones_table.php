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
            $table->foreignId('opcion_id')->constrained()->onDelete('cascade');
            $table->foreignId('residente_id')->constrained('residentes')->onDelete('cascade');
            $table->timestamp('fecha_voto')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('votaciones');
    }
}
