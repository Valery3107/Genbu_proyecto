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
        Schema::create('imagenes', function (Blueprint $table) { 
            $table->id('id_imagen'); 
            $table->foreignId('id_mascota')->constrained('mascotas', 'id_mascota')->cascadeOnDelete(); 
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete(); 
            $table->string('ruta'); 
            $table->string('formato'); 
            $table->unsignedInteger('tamano'); 
            $table->string('dimensiones')->nullable(); 
            $table->decimal('nitidez', 5, 2)->nullable(); 
            $table->string('calidad')->nullable(); 
            $table->boolean('preprocesada')->default(false); 
            $table->timestamp('fecha')->useCurrent(); 
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
