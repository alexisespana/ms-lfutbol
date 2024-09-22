<?php

namespace App\Http\Controllers\Goleadores;

use App\Http\Controllers\Controller;
use App\Models\Goleadores\Goleadores;
use Illuminate\Http\Request;

class GoleadoresController extends Controller
{
    public function TablaGoleadores()
    {
        $Goleadores = Goleadores::with(['jugador.equipo', 'goles_partidos'])->orderBy('cant_goles','DESC')->LIMIT(10)->get();

        return ['data' => $Goleadores];
    }
}
