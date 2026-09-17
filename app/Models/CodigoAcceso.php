<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoAcceso extends Model
{
    protected $table = 'codigos_acceso';
    protected $primaryKey = 'id_codigo';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'rol_asignado',
        'usado',
        'fecha_generacion',
        'fecha_expiracion',
        'fecha_uso',
        'id_administrador',
    ];
}
