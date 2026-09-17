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
        Schema::create('mascotas', function (Blueprint $table) { 
            $table->id('id_mascota'); 
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete(); 
            $table->string('nombre'); 
            $table->string('especie')->nullable(); 
            $table->string('raza'); 
            $table->string('sexo'); 
            $table->string('color_pelaje')->nullable(); 
            $table->date('fecha_nacimiento')->nullable(); 
            $table->string('tutor'); $table->string('telefono_tutor')->nullable(); 
            $table->string('foto')->nullable(); 
            $table->text('observaciones')->nullable(); 
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
