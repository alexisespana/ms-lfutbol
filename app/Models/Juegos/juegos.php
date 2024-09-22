<?php

namespace App\Models\Juegos;

use App\Models\Arbitro\Arbitro;
use App\Models\Categoria\Categoria;
use App\Models\Equipos\Equipos;
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
        'equipo_local',
        'equipo_visitante',
        'fecha',
        'hora',
        'sede',
        'arbitro'
    ];
    public function jornada(){
        return $this->belongsTo(Jornada::class,'id_jornada','id');
    }
    public function resultado()
    {
        return $this->belongsTo(Resultados::class, 'id','id_juego');
    }
    public function equipo_local()
    {
        return $this->belongsTo(Equipos::class, 'equipo_local','id');
    }
    public function equipo_visitante()
    {
        return $this->belongsTo(Equipos::class, 'equipo_visitante','id');
    }
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede','id');
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria','id');
    }
    public function arbitro()
    {
        return $this->belongsTo(Arbitro::class, 'arbitro','id');
    }
}
