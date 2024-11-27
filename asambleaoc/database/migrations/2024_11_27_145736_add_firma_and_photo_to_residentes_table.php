<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('residentes', function (Blueprint $table) {
            $table->longBlob('captura')->nullable();
            $table->longBlob('photo')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('residentes', function (Blueprint $table) {
            $table->dropColumn(['captura', 'photo']);
        });
    }
};
