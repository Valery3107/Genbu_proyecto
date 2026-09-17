<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';
    protected $primaryKey = 'id_reporte';
    public $timestamps = false;

    protected $fillable = [
        'id_diagnostico',
        'id_veterinario',
        'ruta_pdf',
        'incluye_nota',
        'descargado',
        'fecha',
    ];
}
