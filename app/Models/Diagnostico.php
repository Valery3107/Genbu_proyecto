<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table = 'diagnosticos';
    protected $primaryKey = 'id_diagnostico';
    public $timestamps = false;

    protected $fillable = [
        'id_imagen',
        'id_mascota',
        'id_veterinario',
        'enfermedad_detectada',
        'confianza_bacterial_dermatosis',
        'confianza_fungal_infection',
        'confianza_hypersensitivity_dermatitis',
        'confianza_healthy',
        'umbral',
        'version_modelo',
        'recomienda_visita',
        'nota_clinica',
        'confirmado_veterinario',
        'fecha',
    ];
}
