<?php

namespace App\Models\Resultados;

use App\Models\DetallesGoles\DetallesGoles;
use App\Models\Estadisticas_Juego\Estadisticas_juegos;
use App\Models\GolesJuegos\GolesJuegos;
use App\Models\Juegos\juegos;
use App\Models\ReportajeResultados\ReportajeResultados;
use Illuminate\Database\Eloquent\Model;

class Resultados extends Model
{
    protected $table ='resultados';
    protected $fillable = [
        'id_juego',
        'goles_local',
        'goles_visitante',
    ];
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function juego(){
        return $this->hasOne(juegos::class,'id','id_juego');
    }
    public function estadisticas(){
        return $this->hasOne(Estadisticas_juegos::class,'id','id_juego');
    }
    // public function goles(){
    //     return $this->hasMany(GolesJuegos::class,'resultado_id','id')->orderBy('min_gol', 'asc');
    // }
    public function reportaje(){
        return $this->hasone(ReportajeResultados::class,'id_resultado','id');
    }
}
