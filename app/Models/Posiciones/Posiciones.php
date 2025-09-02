<?php

namespace App\Models\Posiciones;

use App\Models\Categoria\Categoria;
use App\Models\Equipos\Equipos;
use App\Models\Grupos\Grupos_Categorias;
use App\Models\Jornada\JornadaCategoria;
use Illuminate\Database\Eloquent\Model;

class Posiciones extends Model
{
    protected $table = 'posiciones';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
       'posicion',
       'id_equipo',
       'idgrupo_categoria',
       'id_jornada',
       'jugados',
       'ganados',
       'empate',
       'perdidos',
       'goles_favor',
       'goles_contra',
       'dif_goles',
       'puntos',

    ];
    public function equipos() {
        return $this->hasOne(Equipos::class, 'id', 'id_equipo');
    }
    public function idgrupo_categoria() {
        return $this->hasOne(Grupos_Categorias::class, 'id', 'idgrupo_categoria');
    }
    public function jornada_categoria() {
        return $this->hasOne(JornadaCategoria::class, 'id', 'id_jornada');
    }
}
