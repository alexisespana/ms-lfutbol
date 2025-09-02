<?php

namespace App\Http\Controllers\Resultados;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CrearTablaPosicionesTraits\CrearTablaPosicionesTraits;
use App\Http\Controllers\Traits\EstadisticasJugadorTraits\EstadisticasJugadorTraits;
use App\Http\Controllers\Traits\EstadisticasResultadosTrait\EstadisticasResultadosTrait;
use App\Models\Categoria\Categoria;
use App\Models\cod_tipo\cod_tipo;
use App\Models\Estadisticas_jugador\Estadisticas_jugador;
use App\Models\Goleadores\Goleadores;
use App\Models\GolesJuegos\GolesJuegos;
use App\Models\Jornada\Jornada;
use App\Models\Juegos\juegos;
use App\Models\Jugadores\Jugadores;
use App\Models\Resultados\Resultados;
use FastRoute\RouteParser\Std;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class ResultadosController extends Controller
{
    use EstadisticasResultadosTrait, EstadisticasJugadorTraits, CrearTablaPosicionesTraits;

    public function index(Request $request)
    {

        // Log::info($request->all());

        // return $request->all() ;

        // dd($request->id);
        $resultados = Resultados::with(['estadisticas', 'juego.equipo_local', 'juego.equipo_visitante',  'reportaje', 'juego.sede', 'juego.jornada.temporada', 'juego.arbitro'])
            ->whereHas('juego.jornada', function ($query) {
                return $query->whereIn('status', [0, 1]);
            })->when($request, function ($query) use ($request) {
                if (isset($request->id)) {
                    $query->where('id_juego', $request->id);
                }
            })->get();

        return $resultados;
    }

    public function RegistrarResultados(Request $request)
    {

        // return $request->all();
        try {
            //  DB::beginTransaction();
            foreach ($request->resultados as $key => $resultados) {

                $resultadoRegistrado = Resultados::where([['id_juego', $resultados['id_juego']], ['status', 3]]);


                if ($resultadoRegistrado->count() > 0) {
                    $message = 'YA SE HA REGISTRADO EL RESULTADO DE ESTE JUEGO!';
                    $status = 500;
                    return response()->json(['message' => $message, 'status' => $status]);
                }
                // SI NO SE HA INSERTADO EL REGISTO INSERTAMOS EL REGISTRO DEL JUEGO 
                else {

                    // return response()->json(['message' => 'saas', 'status' => 500]);

                    $resultado_id = Resultados::insertGetId([
                        'id_juego' => $resultados['id_juego'],
                        'status' => cod_tipo::where('cod_tipo', 3)->first()->id,
                        'cant_goles_eqlocal' =>  count($resultados['goles_eq_local']),
                        'cant_goles_eqvisit' =>  count($resultados['goles_eq_visit']),

                    ]);

                    // PARA MODIFICAR EL STATUS DEL JUEGO UNA VEZ REGISTRADO TODO
                    $id_juego =  juegos::find($resultados['id_juego']);
                    $id_juego->status = cod_tipo::where('cod_tipo', 3)->first()->id;
                    $id_juego->save();

                    // return $id_juego;


                    // //----------------------------   PARA REGISTRAR LOS GOLES DEL JUEGO
                    // foreach ($resultados['goles_eq_local'] as $keys => $jugador_eqLocal) {
                    //     $golesJuego = new GolesJuegos;

                    //     $golesJuego->resultado_id =  $resultado_id;
                    //     $golesJuego->jugador_id = $jugador_eqLocal;
                    //     $golesJuego->min_gol = $resultados['min_goles_eqlocal'][$keys];
                    //     $golesJuego->save();

                    //     $Goleadores = Goleadores::where('jugador_id', $jugador_eqLocal)->first();

                    //     if (is_null($Goleadores)) {
                    //         $Goleadores =  Goleadores::insert([
                    //             'jugador_id'    => $jugador_eqLocal,
                    //             'cant_goles' => 1
                    //         ]);
                    //     } else {
                    //         DB::table('goleadores')->where('jugador_id', $jugador_eqLocal)->update(['cant_goles' => $Goleadores->cant_goles + 1]);
                    //     }


                    // }

                    // foreach ($resultados['goles_eq_visit'] as $keys => $jugador_eqVisit) {
                    //     return $request->all();

                    //     $golesJuego = new GolesJuegos;

                    //     $golesJuego->resultado_id =  $resultado_id;
                    //     $golesJuego->jugador_id = $jugador_eqLocal;
                    //     $golesJuego->min_gol = $resultados['min_goles_eqvisit'][$keys];
                    //     $golesJuego->save();

                    //     $Goleadores = Goleadores::where('jugador_id', $jugador_eqLocal)->first();

                    //     if (is_null($Goleadores)) {
                    //         $Goleadores =  Goleadores::insert([
                    //             'jugador_id'    => $jugador_eqLocal,
                    //             'cant_goles' => 1
                    //         ]);
                    //     } else {
                    //         DB::table('goleadores')->where('jugador_id', $jugador_eqLocal)->update(['cant_goles' => $Goleadores->cant_goles + 1]);
                    //     }
                    // }

                    // ----------------------------------------------------------------
                    //     
                    $resultado =  [
                        [
                            'id_equipo' => $id_juego->id_equipo_local,
                            'ganados' => (count($resultados['goles_eq_local']) > count($resultados['goles_eq_visit']) ? 1 : 0), // si goles_eq_local es mayor quiere decir que el equipo local es el ganador
                            'empate' => (count($resultados['goles_eq_local']) === count($resultados['goles_eq_visit']) ? 1 : 0), // si goles_eq_local es igual quiere decir que el hubo empate en el partido
                            'perdidos' => (count($resultados['goles_eq_local']) < count($resultados['goles_eq_visit']) ? 1 : 0), // si goles_eq_local es mayor quiere decir que el equipo local es el ganador
                            'goles_favor' => count($resultados['goles_eq_local']),
                            'goles_contra' => count($resultados['goles_eq_visit'])
                        ],
                        [
                            'id_equipo' => $id_juego->id_equipo_visitante,
                            'ganados' => (count($resultados['goles_eq_visit']) > count($resultados['goles_eq_local']) ? 1 : 0), // si goles_eq_visit es mayor quiere decir que el equipo visitante es el ganador
                            'empate' => (count($resultados['goles_eq_visit']) === count($resultados['goles_eq_local']) ? 1 : 0), // si goles_eq_visit es mayoigualere decir que el equihubo empate en el partido
                            'perdidos' => (count($resultados['goles_eq_visit']) < count($resultados['goles_eq_local']) ? 1 : 0), // si goles_eq_visit es mayor quiere decir que el equipo visitante es el ganador
                            'goles_favor' =>  count($resultados['goles_eq_visit']),
                            'goles_contra' =>  count($resultados['goles_eq_local']),
                        ]
                    ];
                    
                    $ModificarTablaPosiciones = $this->ModificarTablaPosiciones($resultado, $id_juego);
                    // return response()->json(['message' => $ModificarTablaPosiciones, 'status' => 500]);
                    // $EstadisiticasJugador = $this->EstadisticasResultadosJuegos($resultado_id, $resultados);
                    // $EstadisiticasJugador = $this->EstadisticasJugadorTraits($resultados);


                    // PARA FINANLIZAR LA JORNADA ACTIVA CUANDO SE REGISTREN LOS RESULTADOS DE TODOS LOS JUEGOS DE ESA FECHA

                    $jornada = juegos::where('id', $resultados['id_juego'])->first()->id_jornada;
                    $juegos = juegos::where('id_jornada', $jornada)->whereIn('status',[1,2])->count();

                    if ($juegos < 1) {

                        $jornada = Jornada::find($jornada);
                        $jornada->status = 3;
                        $jornada->save();

                        $jornadaNext = Jornada::where('status', 2)->first()->id;
                        $jornadaProxHabi = Jornada::find($jornadaNext);
                        $jornadaProxHabi->status = 1;
                        $jornadaProxHabi->save();
                    }
                    // return $EstadisiticasJugador;




                    // CREAR LA FUNCION PARA CERRAR LA JORNADA EN CASO DE QUE SE REGISTREN  TODOS LOS RESULTADOS DE LA CATEGORIA Y POR GRUPOS


                    // // -- PARA MODIFICAR LA POSICION DE LOS GOLEADORES Y SU EFECTIVIDAD

                    // $Goleadores = Goleadores::with(['jugador.equipo', 'goles_partidos'])->get();


                    // foreach ($Goleadores as $key => $value) {
                    //     $TotalPartidos = count($value->goles_partidos);
                    //     $goles = $value->cant_goles;

                    //     $promedio = ($goles / $TotalPartidos);
                    //     DB::table('goleadores')->where('id', $value->id)->update(
                    //         [
                    //             'efectividad' => $goles . $TotalPartidos,
                    //             'lugar' => 1
                    //         ]
                    //     );

                    //     # code...
                    // }
                }
            }
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('Ha ocurrido un error al crear el juego ====>
            ' . $e);
            $message = 'Ha ocurrido un error al crear el juego!';
            $status = 500;
            return response()->json(['message' => $message, 'status' => $status]);
        }
        DB::commit();
        return response()->json(['message' => 'Se ha guardado el Resultado del juego Seleccionado.', 'status' => 200]);
    }
}


function ResultadosJornada(Request $request)
{
    return $request->all();

    $categoria = Categoria::where('alias', $request->categoria)->first()->id;

    if ($request->jornada) {

        $jornada = $request->jornada;
    } else {
        $jornada =  Jornada::with(['categoria'])->whereHas('categoria', function ($query) use ($categoria) {
            return $query->where('id', '=', $categoria);
        })->first()->id;
    }

    // dd($jornada);


    $resultados = juegos::with([
        'equipo_local',
        'equipo_visitante',
        'jornada.categoria',
        'jornada.temporada',
        'sede',
        'arbitro',
        'resultado.estadisticas',
        'resultado.reportaje'
    ])->where([['id_jornada', $jornada], ['id_categoria', $categoria]])->get();

    $jornada =  Jornada::with(['categoria'])->whereHas('categoria', function ($query) use ($categoria) {
        return $query->where('id', '=', $categoria);
    })->whereIn('status', [0, 1])->get();
    $Categoria = Categoria::all();

    return [
        'jornada' => $jornada,
        'categoria' => $Categoria,
        'data' => $resultados
    ];
}
