<?php

namespace App\Http\Controllers\Traits\EstadisticasJugadorTraits;

use App\Models\Estadisticas_jugador\Estadisticas_jugador;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait EstadisticasJugadorTraits
{
    function EstadisticasJugadorTraits($resultados)
    {

        $titulares = array_merge($resultados['titulares_equipo_local'], $resultados['titulares_equipo_visit']);
        $cambiosEntran = array_merge($resultados['entra_eq_local'], $resultados['entra_eq_visit']);
        $cambiosSalen = array_merge($resultados['sale_eq_local'], $resultados['sale_eq_visit']);
        $goles = array_merge($resultados['goles_eq_local'], $resultados['goles_eq_visit']);

        // foreach ($cambiosEqLocal as $key => $cambioEqLocal) {

        foreach ($titulares as $key => $Titulares) {

            $EstadisticasJugador = Estadisticas_jugador::where('jugador_id', $Titulares);

            if ($EstadisticasJugador->count() == 0) {
                $this->registrar($Titulares);
            } else {
                $this->Modificar($Titulares);
            }


            foreach ($cambiosEntran as $key => $idJugador_entran) {
                if ($idJugador_entran == $Titulares) {

                    $EstadisticasJugador = Estadisticas_jugador::where('jugador_id', $Titulares);
                    $this->Modificar($Titulares);

                    if ($EstadisticasJugador->count() == 0) {
                        $this->registrar($Titulares);
                    } else {
                    }
                }
            }
        }
        //////////////////////////////// FOREACH PARA REGISTRAR LOS GOLES DEL EQUIPO 

        foreach ($goles as $key => $Goles) {
            $goles = Estadisticas_jugador::where('jugador_id', $Goles);

            if ($goles->count() > 0) {
                DB::table('estadisticas_jugador')->where('jugador_id', $Goles)
                    ->update(['goles' => is_null($goles->first()->goles) ? 1 : ($goles->first()->goles + 1)]);
            }
        }
    }

    public function registrar($titulares)
    {
        $Estadisticas_jugador = new Estadisticas_jugador;
        $Estadisticas_jugador->jugador_id = $titulares;
        $Estadisticas_jugador->partidos = 1;
        $Estadisticas_jugador->goles = null;
        $Estadisticas_jugador->titularidad = 1;
        $Estadisticas_jugador->cambio = 0;
        $Estadisticas_jugador->tarjetas_amarilla = null;
        $Estadisticas_jugador->tarjetas_roja = null;
        $Estadisticas_jugador->save();
    }
    public function Modificar($Titulares)
    {
        // Log::info($Titulares);
        DB::table('estadisticas_jugador')->where('jugador_id', $Titulares)->update(
            [
                'partidos' => 2,
            ]
        );
    }
}
