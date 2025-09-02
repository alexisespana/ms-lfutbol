<?php

namespace App\Models\Posiciones;

use App\Models\Categoria\Categoria;
use App\Models\Equipos\Equipos;
use Illuminate\Database\Eloquent\Model;

class Posiciones extends Model
{
    protected $table = 'posiciones';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
       'posiciones',
       'id_equipo',
       'id_categoria',
       'jugados',
       'ganados',
       'empates',
       'perdidos',
       'goles_favor',
       'goles_contra',
       'diff_goles',
       'puntos',

    ];
    public function equipos() {
        return $this->hasOne(Equipos::class, 'id', 'id_equipo');
    }
    public function categoria() {
        return $this->hasOne(Categoria::class, 'id', 'id_categoria');
    }
}
