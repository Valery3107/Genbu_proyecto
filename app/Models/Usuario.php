<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre_completo',
        'correo',
        'contrasena',
        'numero_documento',
        'telefono',
        'rol',
        'estado',
        'foto_perfil',
        'ultimo_acceso',
        'token_recuperacion',
        'token_expiracion',
        'fecha_registro',
    ];
}
