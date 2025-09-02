<?php

namespace App\Models\EstadisticasJornada;

use App\Models\Juegos\juegos;
use Illuminate\Database\Eloquent\Model;

class EstadisticasJornada extends Model
{
    protected $table = 'Estadisticas_jornada';
    public $timestamps = 'false';
    protected $fillable = [
        'portada',
        'jugador_semana',
        'portero_semana',
        'jugador_torneo',
        'portero_torneo',

    ];
    public function portada()
    {
        return $this->hasMany(juegos::class, 'portada', 'id');
    }
}
