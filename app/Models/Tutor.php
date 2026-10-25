<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutor extends Model
{
    protected $table = 'tutores';
    protected $primaryKey = 'id_tutor';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'telefono',
    ];

    public function mascotas(): HasMany
    {
        return $this->hasMany(Mascota::class, 'id_tutor', 'id_tutor');
    }
}