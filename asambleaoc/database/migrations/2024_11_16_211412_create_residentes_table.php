<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo')->nullable();
            $table->string('apto');
            $table->string('coeficiente');
            $table->longText('firma')->nullable(); // Campo para almacenar la firma como Base64
            $table->longText('photo')->nullable(); // Campo para almacenar la foto como Base64
            $table->timestamps();
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
