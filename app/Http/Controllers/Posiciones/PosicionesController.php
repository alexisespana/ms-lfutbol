<?php

namespace App\Http\Controllers\Posiciones;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CategoriasTraits\CategoriasTraits;
use App\Models\Categoria\Categoria;
use App\Models\Equipos\Equipos;
use App\Models\Jornada\Jornada;
use App\Models\Posiciones\Posiciones;
use App\Models\Resultados\Resultados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PosicionesController extends Controller
{
    use CategoriasTraits;

    public function Posiciones()
    {
        $categorias = $this->Categoria(null);

        $fecha_activa = Jornada::where('status', 3)->orderByDesc('id')
            ->first();

        if (!isset($fecha_activa)) {
            $fecha_activa = Jornada::where('status', 1)->orderByDesc('id')->first();
            if (is_null($fecha_activa)) {

                $fecha_activa = Jornada::where('status', 2)->orderByDesc('id')->first();
            }
        }

        // return $fecha_activa;

        $posiciones = Posiciones::with(['equipos', 'jornada_categoria.jornada', 'idgrupo_categoria.grupos', 'idgrupo_categoria.categorias'])
            ->whereHas('jornada_categoria.jornada', function ($query) use ($fecha_activa) {
                return $query->where('id_jornada', $fecha_activa->id);
            })
            ->orderBy('posicion')->get();

        // SI NO ESTA LA TABLA DE POSICIONES PARA LA FECHA ACTIVA ENTONCES SE MUESTRA LAS POSICIONES DE LA ULTIMA FECHA JUGADA

        return ['posiciones' => $posiciones, 'categorias' => $categorias];
    }
    public function Posiciones_Jornada(Request $request)
    {

        // return $request->all();


        $posiciones = Posiciones::with(['equipos', 'idgrupo_categoria.grupos', 'idgrupo_categoria.categorias'])
            ->where([['id_jornada', $request->id_jornada], ['idgrupo_categoria', $request->id_categoria]])
            ->orderBy('posicion')->get();
        return ['posiciones' => $posiciones];
    }
}
