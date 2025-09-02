<?php

namespace App\Http\Controllers\Jugadores;

use App\Http\Controllers\Controller;
use App\Models\Jugadores\Jugadores;
use App\Models\Jugadores\JugadoresEquipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JugadoresController extends Controller
{
    function index(Request $request)
    {
        $jugadores = Jugadores::when(isset($request->id_jugador), function ($q) use ($request) {
            return $q->where('id',  $request->id_jugador);
        })->get()
            ->map(function ($jugadores, $index) {
                $jugadores->jugadores_equipos = JugadoresEquipos::with(['categorias', 'equipos'])->where('jugador_id', $jugadores->id)->get();

                return $jugadores;
            });

        return $jugadores;
    }
}
