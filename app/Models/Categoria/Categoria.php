<?php

namespace App\Models\Categoria;

use App\Models\Equipos\Equipos;
use App\Models\grupos;
use App\Models\Grupos\Grupos_Categorias;
use App\Models\Jornada\Jornada;
use App\Models\Juegos\juegos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'alias',
        'vigente',
        'grupos',
        'cant_grupos'
    ];
    public function equipos()
    {
        return $this->belongsToMany(Equipos::class, 'categoria_equipo', 'categoria_id', 'equipo_id');
    }
    public function grupos()
    {
        return $this->belongsToMany(grupos::class, 'grupo_categoria', 'categoria_id', 'id');
    }
    public function jornadas()
    {
        return $this->hasMany(Jornada::class, 'id_categoria', 'id');
    }
    public function grupo_categoria()
    {

        return $this->hasMany(Grupos_Categorias::class, 'categoria_id', 'id');
    }
    // public function juegos()
    // {
    //     return $this->hasMany(Grupos_Categorias::class, 'categoria_id', 'id');

    //     // return $this->hasMany(juegos::class,  'id_categoria', 'id');
    // }
}
