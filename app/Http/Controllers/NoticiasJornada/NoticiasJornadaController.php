<?php

namespace App\Http\Controllers\NoticiasJornada;

use App\Http\Controllers\Controller;
use App\Models\Equipos\Equipos;
use App\Models\Jornada\Jornada;
use App\Models\Juegos\juegos;
use App\Models\Jugadores\Jugadores;
use Illuminate\Http\Request;

class NoticiasJornadaController extends Controller
{
    public function NoticiasJornada(Request $request)
    {

        $noticiasJornada = Jornada::with(['EstadisticasJornada'])->where('vigente', 1)->first();
        // foreach ($noticiasJornada as $key => $value) {
            $noticiasJornada->EstadisticasJornada->portada = juegos::with(['resultado.reportaje'])->whereIn('id', json_decode($noticiasJornada->EstadisticasJornada->portada))->get();
            $noticiasJornada->EstadisticasJornada->jugador_semana = Jugadores::with(['equipo'])->where('id', json_decode($noticiasJornada->EstadisticasJornada->jugador_semana))->first();
            $noticiasJornada->EstadisticasJornada->portero_semana = Jugadores::with(['equipo'])->where('id', json_decode($noticiasJornada->EstadisticasJornada->portero_semana))->first();
            $noticiasJornada->EstadisticasJornada->jugador_torneo = Jugadores::with(['equipo'])->where('id', json_decode($noticiasJornada->EstadisticasJornada->jugador_torneo))->first();
            $noticiasJornada->EstadisticasJornada->portero_torneo = Jugadores::with(['equipo'])->where('id', json_decode($noticiasJornada->EstadisticasJornada->portero_torneo))->first();
        // }

        return ['data' => $noticiasJornada];
    }
}
