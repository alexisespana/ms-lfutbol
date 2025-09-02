<?php

namespace App\Models\Juegos;

use App\Models\Arbitro\Arbitro;
use App\Models\Categoria\Categoria;
use App\Models\cod_tipo\cod_tipo;
use App\Models\Equipos\Equipos;
use App\Models\Grupos\Grupos_Categorias;
use App\Models\Jornada\Jornada;
use App\Models\Resultados\Resultados;
use App\Models\Sede\Sede;
use Illuminate\Database\Eloquent\Model;

class juegos extends Model
{
    protected $table = 'juegos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'status',
        'id_jornada',
        'id_categoria',
        'id_equipo_local',
        'id_equipo_visitante',
        'fecha',
        'hora',
        'sede',
        'arbitro'
    ];

    public function status(){
        return $this->belongsTo(cod_tipo::class,'status','id');
    }
    public function jornada(){
        return $this->hasOne(Jornada::class,'id','id_jornada');
    }
    public function resultado()
    {
        return $this->belongsTo(Resultados::class, 'id','id_juego');
    }
    public function equipo_local()
    {
        return $this->belongsTo(Equipos::class, 'id_equipo_local','id');
    }
    public function equipo_visitante()
    {
        return $this->belongsTo(Equipos::class, 'id_equipo_visitante','id');
    }
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede','id');
    }
    public function grupo_categoria()
    {
        // return $this->belongsToMany(Categoria::class, 'grupo_categoria',  'categoria_id','categoria_id');

        
        return $this->belongsTo(Grupos_Categorias::class, 'id_categoria', 'id');

    }
    public function arbitro()
    {
        return $this->belongsTo(Arbitro::class, 'arbitro','id');
    }
    public function resultados()
    {
        return $this->belongsTo(Resultados::class, 'id','id_juego');
    }
}
