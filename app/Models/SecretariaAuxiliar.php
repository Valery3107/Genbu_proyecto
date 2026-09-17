<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecretariaAuxiliar extends Model
{
    protected $table = 'secretarias_auxiliares';
    protected $primaryKey = 'id_secretaria';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'cargo',
        'horario_trabajo',
    ];
}