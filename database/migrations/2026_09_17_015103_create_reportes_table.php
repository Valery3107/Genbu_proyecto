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
        Schema::create('reportes', function (Blueprint $table) { 
            $table->id('id_reporte'); 
            $table->foreignId('id_diagnostico')->constrained('diagnosticos', 'id_diagnostico')->cascadeOnDelete(); 
            $table->foreignId('id_veterinario')->constrained('veterinarios', 'id_veterinario')->cascadeOnDelete(); 
            $table->string('ruta_pdf'); 
            $table->boolean('incluye_nota')->default(false); 
            $table->boolean('descargado')->default(false); 
            $table->timestamp('fecha')->useCurrent(); 
});
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
