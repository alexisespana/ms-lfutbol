<?php

namespace App\Models\Jugadores;

use App\Models\Categoria\Categoria;
use App\Models\Equipos\Equipos;
use Illuminate\Database\Eloquent\Model;

class JugadoresEquipos extends Model
{
     //
     protected $table = 'jugadores_equipos'; //
     protected $primaryKey = 'id';
     public $timestamps = false;
     protected $fillable = [
         'jugador_id',
         'equipo_id',
         'categoria_id',
       
     ];
     public function jugadores()
     {
         return $this->hasOne(Jugadores::class, 'id', 'jugador_id');
     }
     public function equipos()
     {
         return $this->hasOne(Equipos::class, 'id', 'equipo_id');
     }
     public function categorias()
     {
         return $this->hasOne(Categoria::class, 'id', 'categoria_id');
     }
}
