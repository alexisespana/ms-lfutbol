<?php

namespace App\Http\Controllers\Posiciones;

use App\Http\Controllers\Controller;
use App\Models\Categoria\Categoria;
use App\Models\Equipos\Equipos;
use App\Models\Posiciones\Posiciones;
use App\Models\Resultados\Resultados;
use Illuminate\Http\Request;

class PosicionesController extends Controller
{

    public function Posiciones()
    {
        // $resultado = Categoria::with(['equipos'])->where('id',1)->get();
        // dd($resultado[0]->equipos);

        // foreach ($resultado as $key => $eq) {
        //     foreach ($eq->equipos as $key1 => $equipos) {
        //         dd($equipos->id, $eq->id);
        //     }
        // }
        $Categoria = Categoria::all();

        $data = Posiciones::with(['equipos.categoria'])->orderBy('posicion')->get();
        // dd($data);

        
        $beneficiosAg = [];

        foreach ($data as $key => $benf) {
            //Recorremos los datos del array y si no es null agrupamos por anio
            if (!is_null($data[$key])) {

                // dd( $benf->id_categoria);

                $anioBenef = $benf->id_categoria;
                $beneficiosAg[$anioBenef][] = $benf;
            }
        }

        // dd($beneficiosAg);

        // AQUI LIMPIAMOS EL ARRAY DATA DE TODOS LOS VALORES QUE VENGAN NULL

        $posiciones = [];
        //  SI EL ARRAY TIENE ALGUN BENEFICIO LO RECORREMOS PARA CONTAR LA CANTIDAD DE CADA BENEFICIO POR AÑO
      
            foreach ($beneficiosAg as $key => $value) {
                
                $posiciones[] = (object)[
                    'categoria' => $key,
                    'cantidad_equipos' => count($value),
                    'equipos' => $value,
                ];
            }
        
        // dd($posiciones);

        return
            [
                'data' => $posiciones,
                'categoria' => $Categoria
            ];
    }
}
