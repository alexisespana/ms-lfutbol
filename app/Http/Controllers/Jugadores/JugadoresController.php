<?php

namespace App\Http\Controllers\Jugadores;

use App\Http\Controllers\Controller;
use App\Models\Jugadores\Jugadores;
use Illuminate\Http\Request;

class JugadoresController extends Controller
{
    function index(Request $request) {
        
        $jugadores = Jugadores::with(['equipo'])->get();
        return $jugadores;
    }
}
