<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesiones';
    protected $primaryKey = 'id_sesion';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'token',
        'fecha_inicio',
        'fecha_expiracion',
        'ip',
        'activa',
    ];
}