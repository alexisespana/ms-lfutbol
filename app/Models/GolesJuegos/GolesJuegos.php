<?php

namespace App\Models\GolesJuegos;

use App\Models\Jugadores\Jugadores;
use Illuminate\Database\Eloquent\Model;

class GolesJuegos extends Model
{
    protected $table = 'goles_juegos';
    public $timestamps = 'false';
    protected $fillable = [
        'resultado_id',
        'jugador_id',
        'min_gol',

    ];

    public function jugador(){
        return $this->hasOne(Jugadores::class, 'id', 'jugador_id');
    }
}
