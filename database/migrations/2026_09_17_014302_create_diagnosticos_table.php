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
        Schema::create('diagnosticos', function (Blueprint $table) { 
            $table->id('id_diagnostico'); 
            $table->foreignId('id_imagen')->constrained('imagenes', 'id_imagen')->cascadeOnDelete(); 
            $table->foreignId('id_mascota')->constrained('mascotas', 'id_mascota')->cascadeOnDelete(); 
            $table->foreignId('id_veterinario')->constrained('veterinarios', 'id_veterinario')->cascadeOnDelete(); 
            $table->string('enfermedad_detectada'); 
            $table->decimal('confianza_bacterial_dermatosis', 5, 2)->nullable(); 
            $table->decimal('confianza_fungal_infection', 5, 2)->nullable(); 
            $table->decimal('confianza_hypersensitivity_dermatitis', 5, 2)->nullable(); 
            $table->decimal('confianza_healthy', 5, 2)->nullable(); 
            $table->decimal('umbral', 5, 2)->nullable(); 
            $table->string('version_modelo')->nullable(); 
            $table->boolean('recomienda_visita')->default(false); 
            $table->text('nota_clinica')->nullable(); 
            $table->boolean('confirmado_veterinario')->default(false); $table->timestamp('fecha')->useCurrent(); 
});
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosticos');
    }
};
