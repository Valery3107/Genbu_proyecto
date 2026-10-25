<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mascota extends Model
{
    protected $table = 'mascotas';
    protected $primaryKey = 'id_mascota';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_tutor',
        'nombre',
        'especie',
        'raza',
        'sexo',
        'color_pelaje',
        'fecha_nacimiento',
        'foto',
        'observaciones',
    ];

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class, 'id_tutor', 'id_tutor');
    }
}
