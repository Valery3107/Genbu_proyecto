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
        Schema::create('secretarias_auxiliares', function (Blueprint $table) { 
            $table->id('id_secretaria'); 
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete(); 
            $table->string('cargo'); 
            $table->string('horario_trabajo'); 
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secretarias_auxiliares');
    }
};
