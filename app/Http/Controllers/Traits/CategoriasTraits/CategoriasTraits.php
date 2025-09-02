<?php

namespace App\Http\Controllers\Traits\CategoriasTraits;

use App\Models\Categoria\Categoria;
use App\Models\Categoria\Categoria_Equipo;
use App\Models\Categoria\CategoriaTraits;
use App\Models\grupos;
use App\Models\Jugadores\Jugadores;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait CategoriasTraits
{
    public function Categoria($id_categoria)
    {

        $categorias = Categoria::with([
            'equipos',
            'grupos',
            'grupo_categoria.categorias',
            'grupo_categoria.grupos',
            'grupo_categoria.jornadas.jornada.status',
            'grupo_categoria.jornadas.categoria',
            'grupo_categoria.jornadas.jornada.juegos.equipo_local',
            'grupo_categoria.jornadas.jornada.juegos.equipo_visitante',
            'grupo_categoria.jornadas.jornada.juegos.sede',
            'grupo_categoria.juegos.status',
            'grupo_categoria.juegos.resultados.estadisticas_resultados',
            'grupo_categoria.juegos.jornada.status',
            'grupo_categoria.juegos.equipo_local',
            'grupo_categoria.juegos.equipo_visitante',
            'grupo_categoria.juegos.sede',
            'grupo_categoria.juegos.arbitro',
            'jornadas.status',
            'jornadas.juegos',
            'jornadas.juegos.equipo_local',
            'jornadas.juegos.equipo_visitante',
            'jornadas.juegos.sede',
            'jornadas.juegos.arbitro',


        ])
            ->when(isset($id_categoria), function ($q) use ($id_categoria) {
                return $q->where('id',  $id_categoria);
            })->where('vigente', 1)
            ->get()
        ->map(function ($categorias, $index) {


            if (isset($categorias->grupo_categoria)) {
                foreach ($categorias->grupo_categoria as $key => $grup) {

                    $categorias->grupo_categoria[$key]->equipos =
                        Categoria_Equipo::with(['grupos', 'equipos'])->where('categoria_id', $grup->categoria_id)
                        ->where('grupo_id', $grup->grupo_id)
                        ->get();

                          //EN CASO DE QUE EL JUEGO YA TENGA RESULTADO CREADOS------------
              if (isset( $categorias->grupo_categoria[$key]->juegos)) {
                foreach ($categorias->grupo_categoria[$key]->juegos as $key => $juegos) {
                    if (isset($juegos->resultados->estadisticas_resultados)) {
                        // Log::alert();
    
                        $juegos->resultados->estadisticas_resultados->titulares_eq_local = Jugadores::whereIn('id', collect(explode(',',$juegos->resultados->estadisticas_resultados->titulares_eq_local)))->get('nombre');
                    }
                }
                // Log::alert();

            }

                }
            } else {
                $categorias->grupo_categoria->equipos = $categorias->grupo_categoria;
            }

            

            return $categorias;


        });

        if (count($categorias) < 1) {
            return response()->json(['message' => 'No existen Categorias creadas.', 'status' => 500], 500);


            //PRIMERO SE DEBE VERIFICAR QUE LAS CATEGORIAS TENGAS LOS EQUIPOS ASIGNADOS EN LOS GRUPOS CREADOS
            $categSinEquip = [];
            foreach ($categorias as $key => $categ) {
                $grupoIncompleto = 'true';
                foreach ($categ->grupo_categoria as  $value) {
                    if (count($value->equipos) < 1) {
                        $grupoIncompleto = 'false';
                    }
                }
                // SI ENCONTRAMOS UNO MAS CATEGORIAS CON GRUPOS SIN EQUIPOS ASIGNADOS ENVIAMOS UN ERROR
                if ($grupoIncompleto == 'false') {
                    array_push($categSinEquip, $categ->nombre);
                }
            }
            return response()->json(['error' => $categSinEquip]);
        }
        return $categorias;
    }
}
