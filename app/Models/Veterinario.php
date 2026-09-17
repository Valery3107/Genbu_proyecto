<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinario extends Model
{
    protected $table = 'veterinarios';
    protected $primaryKey = 'id_veterinario';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'tarjeta_profesional',
        'especializacion',
        'cargo',
        'numero_consultorio',
        'horario_trabajo',
        'estado_actual',
        'lugar_residencia',
    ];
}