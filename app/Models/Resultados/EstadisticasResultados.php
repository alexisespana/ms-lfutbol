<?php

namespace App\Models\Resultados;

use App\Models\Jugadores\Jugadores;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EstadisticasResultados extends Model
{
    protected $table = 'estadisticas_resultados';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'resultado_id',
        'titulares_eq_local',
        'suplentes_eq_local',
        'cambio_entra_eq_local',
        'cambio_sale_eq_local',
        'min_cambio_eq_local',
        'goles_eq_local',
        'min_goles_eq_local',
        'tarjeta_ama_eq_local',
        'min_ama_eq_local',
        'tarjeta_roja_eq_local',
        'min_roja_eq_local',

        'titulares_eq_visit',
        'suplentes_eq_visit',
        'cambio_entra_eq_visit',
        'cambio_sale_eq_visit',
        'min_cambio_eq_visit',
        'goles_eq_visit',
        'min_goles_eq_visit',
        'tarjeta_ama_eq_visit',
        'min_ama_eq_visit',
        'tarjeta_roja_eq_visit',
        'min_roja_eq_visit',



    ];

    public function titulares_eq_local(){

      
    }

}
