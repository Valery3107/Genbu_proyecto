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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre_completo');
            $table->string('correo')->unique();
            $table->string('contrasena');
            $table->string('numero_documento')->unique();
            $table->string('telefono')->nullable();
            $table->enum('rol', ['veterinario', 'secretaria', 'administrador']);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->string('foto_perfil')->nullable();
            $table->timestamp('ultimo_acceso')->nullable();
            $table->string('token_recuperacion')->nullable();
            $table->timestamp('token_expiracion')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
    /**
     * ejemplo uso de versiones 
     */
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
