<?php

namespace App\Models\Estadisticas_jugador;

use Illuminate\Database\Eloquent\Model;

class Estadisticas_jugador extends Model
{
     //
     protected $table = 'estadisticas_jugador';
     protected $primaryKey = 'id';
     public $timestamps = false;
     protected $fillable = [
         'jugador_id',
         'partidos',
         'goles',
         'titularidad',
         'cambio',
         'tarjetas_amarilla',
         'tarjetas_roja',
         
     ];
}
