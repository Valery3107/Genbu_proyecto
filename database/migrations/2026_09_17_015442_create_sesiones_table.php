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
        Schema::create('sesiones', function (Blueprint $table) { 
            $table->id('id_sesion'); 
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete(); 
            $table->string('token')->unique(); 
            $table->timestamp('fecha_inicio')->useCurrent(); 
            $table->timestamp('fecha_expiracion')->nullable(); 
            $table->string('ip')->nullable(); 
            $table->boolean('activa')->default(true); 
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
