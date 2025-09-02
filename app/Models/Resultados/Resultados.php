<?php

namespace App\Models\Resultados;

use App\Models\Juegos\juegos;
use App\Models\ReportajeResultados\ReportajeResultados;
use Illuminate\Database\Eloquent\Model;

class Resultados extends Model
{
    protected $table = 'resultados';
    public $timestamps = true;

    protected $fillable = [
        'id_juego',
        'cant_goles_eqlocal',
        'cant_goles_eqvisit',
        'idjugador_goles_eq_local',
        'min_goles_eq_local',
        'idjugador_goles_eq_visit',
        'min_goles_eq_visit',
        'cambio_sale_eq_local',
        'cambio_entra_eq_local',
        'min_cambio_eq_local',
        'cambio_sale_eq_visit',
        'cambio_entra_eq_visit',
        'min_cambio_eq_visit',
        'tarjetas_ama_eq_local',
        'min_tarjetas_ama__eq_local',
        'tarjetas_ama_eq_visit',
        'min_tarjetas_ama_eq_visit',
        'tarjetas_roja_eq_local',
        'min_tarjetas_roja__eq_local',
        'tarjetas_roja_eq_visit',
        'min_tarjetas_roja_eq_visit',
        'status'
    ];
    // public $timestamps = false;
    protected $primaryKey = 'id';

    public function juego()
    {
        return $this->hasOne(juegos::class, 'id', 'id_juego');
    }
    public function estadisticas_resultados()
    {
        return $this->hasOne(EstadisticasResultados::class, 'resultado_id', 'id');
    }
    // public function goles(){
    //     return $this->hasMany(GolesJuegos::class,'resultado_id','id')->orderBy('min_gol', 'asc');
    // }
    public function reportaje()
    {
        return $this->hasone(ReportajeResultados::class, 'id_resultado', 'id');
    }
}
