<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $table = 'mascotas';
    protected $primaryKey = 'id_mascota';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nombre',
        'especie',
        'raza',
        'sexo',
        'color_pelaje',
        'fecha_nacimiento',
        'tutor',
        'telefono_tutor',
        'foto',
        'observaciones',
    ];
}
