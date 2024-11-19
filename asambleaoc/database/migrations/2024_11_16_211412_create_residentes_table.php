<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('residentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo')->nullable();
            $table->string('apto');
            $table->string('coeficiente'); // Permitir un valor predeterminado
            $table->longText('captura')->nullable();
            $table->timestamps();
        });

        Schema::table('residentes', function (Blueprint $table) {
            $table->longBlob('captura')->nullable();  // Asegúrate de que la columna permita valores nulos si no es obligatoria
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residentes');
    }
};
