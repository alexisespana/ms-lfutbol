<?php

namespace App\Models\Grupos;

use App\Models\Categoria\Categoria;
use App\Models\grupos;
use App\Models\Jornada\JornadaCategoria;
use App\Models\Juegos\juegos;
use Illuminate\Database\Eloquent\Model;

class Grupos_Categorias extends Model
{
    protected $table = 'grupo_categoria';
    protected $fillable = [
        'categoria_id',
        'grupo_id',
    ];

    //CORREGIR ESTAS RELACIONES
    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id','id');
    }
    public function grupos()
    {
        
        return $this->belongsTo(grupos::class,  'grupo_id', 'id');

    }
    public function juegos()
    {
        return $this->hasMany(juegos::class, 'id_categoria','id');
    }
    public function jornadas()
    {
        return $this->hasMany(JornadaCategoria::class, 'categoria_id','id');
    }
}
