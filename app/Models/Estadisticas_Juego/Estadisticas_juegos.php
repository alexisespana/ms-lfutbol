<?php

namespace App\Models\Estadisticas_Juego;

use App\Models\Jugadores\Jugadores;
use Illuminate\Database\Eloquent\Model;

class Estadisticas_juegos extends Model
{
    protected $table = 'estadisticas_juegos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'juego_id',
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

    public function jugadores_eq_local(){
        return $this->belongsTo(Jugadores::class, 'titulares_eq_local','id');
    }
}
