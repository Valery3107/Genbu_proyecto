<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';
    protected $primaryKey = 'id_imagen';
    public $timestamps = false;

    protected $fillable = [
        'id_mascota',
        'id_usuario',
        'ruta',
        'formato',
        'tamano',
        'dimensiones',
        'nitidez',
        'calidad',
        'preprocesada',
        'fecha',
    ];
}
