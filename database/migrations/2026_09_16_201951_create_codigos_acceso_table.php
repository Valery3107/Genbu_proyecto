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
        Schema::create('codigos_acceso', function (Blueprint $table) {
            $table->id('id_codigo'); 
            $table->string('codigo')->unique(); 
            $table->enum('rol_asignado', ['veterinario', 'secretaria']); 
            $table->boolean('usado')->default(false); 
            $table->timestamp('fecha_generacion')->useCurrent(); 
            $table->timestamp('fecha_expiracion')->nullable(); 
            $table->timestamp('fecha_uso')->nullable(); 
            $table->foreignId('id_administrador')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete(); 
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigos_acceso');
    }
};
