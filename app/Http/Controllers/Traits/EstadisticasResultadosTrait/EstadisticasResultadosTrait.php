<?php

namespace App\Http\Controllers\Traits\EstadisticasResultadosTrait;

use App\Models\Resultados\EstadisticasResultados;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait EstadisticasResultadosTrait
{
    function EstadisticasResultadosJuegos($resultado_id, $resultados)
    {

        try {

            $suplentes_eq_local = '';

            $JugadorTitulares = new EstadisticasResultados;

            $JugadorTitulares->resultado_id = $resultado_id;
            $JugadorTitulares->titulares_eq_local = collect($resultados['titulares_equipo_local'])->implode(',');
            $JugadorTitulares->suplentes_eq_local = $suplentes_eq_local;
            $JugadorTitulares->suplentes_eq_local = null;
            $JugadorTitulares->cambio_entra_eq_local = collect($resultados['entra_eq_local'])->implode(',');
            $JugadorTitulares->cambio_sale_eq_local = collect($resultados['sale_eq_local'])->implode(',');
            $JugadorTitulares->min_cambio_eq_local = collect($resultados['min_cambio_eq_local'])->implode(',');
            $JugadorTitulares->goles_eq_local = collect($resultados['goles_eq_local'])->implode(',');;
            $JugadorTitulares->min_goles_eq_local = collect($resultados['min_goles_eqlocal'])->implode(',');
            $JugadorTitulares->tarjeta_ama_eq_local = collect($resultados['tarjetas_eq_local'])->implode(',');
            $JugadorTitulares->min_ama_eq_local = collect($resultados['min_tarjetas_eq_local'])->implode(',');
            $JugadorTitulares->tarjeta_roja_eq_local = null;
            $JugadorTitulares->min_roja_eq_local = null;
            $JugadorTitulares->titulares_eq_visit = collect($resultados['titulares_equipo_visit'])->implode(',');
            $JugadorTitulares->suplentes_eq_visit = null;
            $JugadorTitulares->cambio_entra_eq_visit = collect($resultados['entra_eq_visit'])->implode(',');
            $JugadorTitulares->cambio_sale_eq_visit = collect($resultados['sale_eq_visit'])->implode(',');
            $JugadorTitulares->min_cambio_eq_visit = collect($resultados['min_cambio_eq_visit'])->implode(',');
            $JugadorTitulares->goles_eq_visit = collect($resultados['goles_eq_visit'])->implode(',');
            $JugadorTitulares->min_goles_eq_visit = collect($resultados['min_goles_eqvisit'])->implode(',');
            $JugadorTitulares->tarjeta_ama_eq_visit = collect($resultados['tarjetas_eq_visit'])->implode(',');
            $JugadorTitulares->min_ama_eq_visit = collect($resultados['min_tarjetas_eq_visit'])->implode(',');
            $JugadorTitulares->tarjeta_roja_eq_visit = null;
            $JugadorTitulares->min_roja_eq_visit = null;

            $JugadorTitulares->save();
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('Ha ocurrido un error en EstadisticasResltadosTRaits ====>
        ' . $e);
            $message = 'Ha ocurrido un error al insertar la estadisticas del resultados!';
            $status = 500;

            return response()->json(['message' => $message, 'status' => $status]);
        }
    }
}
