<?php

namespace App\Http\Controllers\Juegos;

use App\Http\Controllers\Controller;
use App\Models\Juegos\juegos;
use Illuminate\Http\Request;

class JuegosController extends Controller
{
    //
    public function index(Request $request){

        $juegos = juegos::with(['jornada','equipo_local.jugadores'])->whereHas('jornada', function ($query) {
            return $query->where('vigente', '=', 1);
        })->get();
        return $juegos;
    }
}
