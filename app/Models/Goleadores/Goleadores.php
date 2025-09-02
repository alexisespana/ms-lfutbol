<?php

namespace App\Models\Goleadores;

use App\Models\GolesJuegos\GolesJuegos;
use App\Models\Jugadores\Jugadores;
use Illuminate\Database\Eloquent\Model;

class Goleadores extends Model
{
    protected $table ='goleadores';
    public $timestamps = 'false';
    protected $fillable = [
        'jugador_id',
        'cant_goles',
        'lugar',
        'efectividad',

    ];
    public function goles_partidos(){
        return $this->hasMany(GolesJuegos::class, 'jugador_id','jugador_id');
    }

    public function jugador(){
        return $this->hasOne(Jugadores::class, 'id', 'jugador_id');
    }

}
