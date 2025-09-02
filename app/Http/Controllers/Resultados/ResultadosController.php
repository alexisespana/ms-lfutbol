<?php

namespace App\Http\Controllers\Resultados;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\EstadisticasResultadosTrait\EstadisticasResultadosTrait;
use App\Models\Categoria\Categoria;
use App\Models\Jornada\Jornada;
use App\Models\Juegos\juegos;
use App\Models\Jugadores\Jugadores;
use App\Models\Resultados\Resultados;
use FastRoute\RouteParser\Std;
use Illuminate\Http\Request;
use stdClass;

class ResultadosController extends Controller
{
    use EstadisticasResultadosTrait;

    public function index(Request $request)
    {

        // return [ 'data' =>$request->id ];

        // dd($request->id);
        $resultados = Resultados::with(['estadisticas', 'juego.equipo_local', 'juego.equipo_visitante',  'reportaje', 'juego.sede', 'juego.jornada.temporada', 'juego.arbitro'])
            ->whereHas('juego.jornada', function ($query) {
                return $query->whereIn('vigente', [0, 1]);
            })->when($request, function ($query) use ($request) {
                if (isset($request->id)) {
                    $query->where('id_juego', $request->id);
                }
            })->get();

            // dd($resultados);
            $jornada =  Jornada::with(['categoria'])->whereHas('categoria', function ($query) use ($resultados) {
                return $query->where('id', '=', $resultados[0]->juego->id_categoria);
            })->whereIn('vigente', [0, 1])->get();
        // $jornada = Jornada::with('temporada')
        // ->whereHas('categoria', function ($query) use ($resultados) {
        //     return $query->where('id_categoria', '=', $resultados[0]->juego->id_categoria);
        // })
        // ->where('vigente', 1)->get();


        foreach ($resultados as $key => $value) {
            $JugEqlocalAll = array_merge(json_decode($value->estadisticas->titulares_eq_local), json_decode($value->estadisticas->suplentes_eq_local));
            $GolsJugEqLocal = json_decode($value->estadisticas->goles_eq_local);
            $CambSalenEqLocal = json_decode($value->estadisticas->cambio_sale_eq_local);
            $CambEntranEqLocal = json_decode($value->estadisticas->cambio_entra_eq_local);
            $tarjAmaEqLocal = json_decode($value->estadisticas->tarjeta_ama_eq_local);
            $tarjRojaEqLocal = json_decode($value->estadisticas->tarjeta_roja_eq_local);

            $JugEqVistAll = array_merge(json_decode($value->estadisticas->titulares_eq_visit), json_decode($value->estadisticas->suplentes_eq_visit));
            $GolsJugEqVisit = json_decode($value->estadisticas->goles_eq_visit);
            $CambSalenEqVisit = json_decode($value->estadisticas->cambio_sale_eq_visit);
            $CambEntranEqVisit = json_decode($value->estadisticas->cambio_entra_eq_visit);
            $tarjAmaEqVisit = json_decode($value->estadisticas->tarjeta_ama_eq_visit);
            $tarjRojaEqVisit = json_decode($value->estadisticas->tarjeta_roja_eq_visit);




            // -- EQUIPO LOCAL----
            // $value->estadisticas->jugadores = Jugadores::with(['equipo:nombre,id'])->whereIn('id', json_decode($value->estadisticas->titulares_eq_local))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->titulares_eq_local = Jugadores::with(['equipo:nombre,id'])->whereIn('id', json_decode($value->estadisticas->titulares_eq_local))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->suplentes_eq_local = Jugadores::whereIn('id', json_decode($value->estadisticas->suplentes_eq_local))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            // $value->estadisticas->goles_eq_local = json_decode($value->estadisticas->goles_eq_local);
            $juga = [];
            $goles = json_decode($value->estadisticas->goles_eq_local);
            foreach ($JugEqlocalAll as $key => $jugadores) {
                foreach ($goles as $key => $golesEqLocal) {
                    if ($jugadores == $golesEqLocal) {
                        $jugador = Jugadores::with(['equipo:nombre,id'])->where('id', $golesEqLocal)->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->first();
                        array_push($juga, $jugador);
                        // dd($jugadores);
                        // foreach ($TitularesEqLocal as $key => $titu) {
                        //     if ($titu->id == $gol) {
                        //         array_push($golesEncont[$gol],  $MinGolesEqLocal[$keygol]);
                        //     }
                        // }
                    }
                }
            }
            $value->estadisticas->goles_eq_local = $juga;

            // dd($value->estadisticas->jugadores);
            // $value->estadisticas->goles_eq_local = Jugadores::whereIn('id', json_decode($value->estadisticas->goles_eq_local))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->min_goles_eq_local = explode(",", str_replace(['[', ']'], '', $value->estadisticas->min_goles_eq_local));
            if (isset($value->estadisticas->cambio_entra_eq_local)) {
                $value->estadisticas->cambio_entra_eq_local = Jugadores::whereIn('id', json_decode($value->estadisticas->cambio_entra_eq_local))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            }
            if (isset($value->estadisticas->cambio_sale_eq_local)) {

                $value->estadisticas->cambio_sale_eq_local = Jugadores::whereIn('id', json_decode($value->estadisticas->cambio_sale_eq_local))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            }
            if (isset($value->estadisticas->min_cambio_eq_local)) {

                $value->estadisticas->min_cambio_eq_local = explode(",", str_replace(['[', ']'], '', $value->estadisticas->min_cambio_eq_local));
            }
            $value->estadisticas->tarjeta_ama_eq_local = Jugadores::whereIn('id', json_decode($value->estadisticas->tarjeta_ama_eq_local))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->min_ama_eq_local = explode(",", str_replace(['[', ']'], '', $value->estadisticas->min_ama_eq_local));
            $value->estadisticas->tarjeta_roja_eq_local = Jugadores::whereIn('id', json_decode($value->estadisticas->tarjeta_roja_eq_local))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->min_roja_eq_local = explode(",", str_replace(['[', ']'], '', $value->estadisticas->min_roja_eq_local));

            // -- EQUIPO VISITANTE ---
            $value->estadisticas->titulares_eq_visit = Jugadores::whereIn('id', json_decode($value->estadisticas->titulares_eq_visit))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->suplentes_eq_visit = Jugadores::whereIn('id', json_decode($value->estadisticas->suplentes_eq_visit))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->goles_eq_visit = Jugadores::whereIn('id', json_decode($value->estadisticas->goles_eq_visit))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->min_goles_eq_visit = explode(",", str_replace(['[', ']'], '', $value->estadisticas->min_goles_eq_visit));
            $value->estadisticas->cambio_entra_eq_visit = Jugadores::whereIn('id', json_decode($value->estadisticas->cambio_entra_eq_visit))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->cambio_sale_eq_visit = Jugadores::whereIn('id', json_decode($value->estadisticas->cambio_sale_eq_visit))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->min_cambio_eq_visit = explode(",", str_replace(['[', ']'], '', $value->estadisticas->min_cambio_eq_visit));
            $value->estadisticas->tarjeta_ama_eq_visit = Jugadores::whereIn('id', json_decode($value->estadisticas->tarjeta_ama_eq_visit))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->min_ama_eq_visit = explode(",", str_replace(['[', ']'], '', $value->estadisticas->min_ama_eq_visit));
            $value->estadisticas->tarjeta_roja_eq_visit = Jugadores::whereIn('id', json_decode($value->estadisticas->tarjeta_roja_eq_visit))->select('id', 'nombre', 'apellidos', 'posicion', 'imagen')->get();
            $value->estadisticas->min_roja_eq_visit = explode(",", str_replace(['[', ']'], '', $value->estadisticas->min_roja_eq_visit));


            $TitularesEqLocal = $value->estadisticas->titulares_eq_local;
            $SuplentesEqLocal = $value->estadisticas->suplentes_eq_local;
            $MinGolesEqLocal = $value->estadisticas->min_goles_eq_local;
            $MinCambioEqLocal = $value->estadisticas->min_cambio_eq_local;
            $MinTarjAmaEqLocal = $value->estadisticas->min_ama_eq_local;
            $MinTarjRojaEqLocal = $value->estadisticas->min_roja_eq_local;

            $TitularesEqVisit = $value->estadisticas->titulares_eq_visit;
            $SuplentesEqVisit = $value->estadisticas->suplentes_eq_visit;
            $MinGolesEqVisit = $value->estadisticas->min_goles_eq_visit;
            $MinCambioEqVisit = $value->estadisticas->min_cambio_eq_visit;
            $MinTarjAmaEqVisit = $value->estadisticas->min_ama_eq_visit;
            $MinTarjRojaEqVisit = $value->estadisticas->min_roja_eq_visit;


            // function date_compare($a, $b)
            // {
            //     dd($a);
            //     $t1 = strtotime($a['startDate']);
            //     $t2 = strtotime($b['startDate']);
            //     return $t1 - $t2;
            // }    
            // $minutos = new StdClass();

            // $minutos->goles = [];
            // $Min = array_merge($MinGolesEqLocal,$MinCambioEqLocal,$MinTarjAmaEqLocal, $MinTarjRojaEqLocal);
            // $Actions = array_merge($GolsJugEqLocal,$CambSalenEqLocal,$tarjAmaEqLocal, $tarjRojaEqLocal);
            // foreach ($Min as $key => $value) {
            //     $minutos->goles[$key] = new StdClass();
            //     $minutos->goles[$key]->id =$Actions[$key];
            //     $minutos->goles[$key]->min =$value;

            //     // $minutos->goles[$key]  = ['name' => $GolsJugEqLocal[$key],'value'=>$value];
            //     // $minutos->goles = ['name' =>  $value];
            //     // array_push($minutos->goles, ['gol'=>$value]);
            //     # code...
            // }


            // dd($minutos);
            //----------------------- GOLES DE LOS JUGADORES TITULARES Y SUPLENTES DEL EQUIPO LOCAL -----------------------
            if (isset($value->estadisticas->titulares_eq_local)) {

                $estadEqlocal =  $this->EstadisticasResultadosEquipoLocal($JugEqlocalAll, $TitularesEqLocal, $SuplentesEqLocal, $GolsJugEqLocal, $MinGolesEqLocal, $CambSalenEqLocal, $CambEntranEqLocal, $MinCambioEqLocal, $tarjAmaEqLocal, $MinTarjAmaEqLocal, $tarjRojaEqLocal, $MinTarjRojaEqLocal);
                // dd($estadEqlocal,$CambSalenEqLocal, $MinCambioEqLocal);

                //----------------------- GOLES, CAMBIOS, TARJETAS DE LOS JUGADORES TITULARES DEL EQUIPO LOCAL -----------------------

                foreach ($value->estadisticas->titulares_eq_local  as $key => $titeqLocal) {
                    $value->estadisticas->titulares_eq_local[$key]->gol = [];
                    $value->estadisticas->titulares_eq_local[$key]->cambiosale = [];
                    $value->estadisticas->titulares_eq_local[$key]->amarilla = [];
                    $value->estadisticas->titulares_eq_local[$key]->roja = [];
                    //----------------------- GOLES DE LOS JUGADORES TITULARES DEL EQUIPO LOCAL -----------------------
                    if (array_key_exists($titeqLocal->id, $estadEqlocal['goles'])) {
                        $value->estadisticas->titulares_eq_local[$key]->gol = $estadEqlocal['goles'][$titeqLocal->id];
                    }
                    //----------------------- CAMBIOS QUE SALEN DE LOS JUGADORES TITULARES DEL EQUIPO LOCAL -----------------------
                    if (array_key_exists($titeqLocal->id, $estadEqlocal['cambiosSalen'])) {
                        $value->estadisticas->titulares_eq_local[$key]->cambiosale = $estadEqlocal['cambiosSalen'][$titeqLocal->id];
                    }
                    //----------------------- TARJETAS AMARILLAS DE LOS JUGADORES TITULARES DEL EQUIPO LOCAL -----------------------
                    if (array_key_exists($titeqLocal->id, $estadEqlocal['amarillas'])) {
                        $value->estadisticas->titulares_eq_local[$key]->amarilla = $estadEqlocal['amarillas'][$titeqLocal->id];
                    }
                    //----------------------- TARJETAS ROJAS DE LOS JUGADORES TITULARES DEL EQUIPO LOCAL -----------------------
                    if (array_key_exists($titeqLocal->id, $estadEqlocal['rojas'])) {
                        $value->estadisticas->titulares_eq_local[$key]->roja = $estadEqlocal['rojas'][$titeqLocal->id];
                    }
                }
                //----------------------- GOLES, CAMBIOS, TARJETAS DE LOS JUGADORES SUPLENTES DEL EQUIPO LOCAL -----------------------

                foreach ($value->estadisticas->suplentes_eq_local  as $key => $supleqLocal) {
                    $value->estadisticas->suplentes_eq_local[$key]->gol = [];
                    $value->estadisticas->suplentes_eq_local[$key]->cambioentra = [];
                    $value->estadisticas->suplentes_eq_local[$key]->amarilla = [];
                    $value->estadisticas->suplentes_eq_local[$key]->roja = [];

                    //----------------------- GOLES DE LOS JUGADORES SUPLENTES DEL EQUIPO LOCAL -----------------------
                    if (array_key_exists($supleqLocal->id, $estadEqlocal['goles'])) {
                        $value->estadisticas->suplentes_eq_local[$key]->gol = $estadEqlocal['goles'][$supleqLocal->id];
                    }
                    //----------------------- CAMBIOS QUE ENTRAN DE LOS JUGADORES SUPLENTES DEL EQUIPO LOCAL -----------------------
                    if (array_key_exists($supleqLocal->id, $estadEqlocal['cambiosEntran'])) {
                        $value->estadisticas->suplentes_eq_local[$key]->cambioentra = $estadEqlocal['cambiosEntran'][$supleqLocal->id];
                    }
                    //----------------------- TARJETAS AMARILLAS DE LOS JUGADORES SUPLENTES DEL EQUIPO LOCAL -----------------------
                    if (array_key_exists($supleqLocal->id, $estadEqlocal['amarillas'])) {
                        $value->estadisticas->suplentes_eq_local[$key]->amarilla = $estadEqlocal['amarillas'][$supleqLocal->id];
                    }
                    //----------------------- TARJETAS ROJAS DE LOS JUGADORES SUPLENTES DEL EQUIPO LOCAL -----------------------
                    if (array_key_exists($supleqLocal->id, $estadEqlocal['rojas'])) {
                        $value->estadisticas->suplentes_eq_local[$key]->roja = $estadEqlocal['rojas'][$supleqLocal->id];
                    }
                }
            }
            //----------------------- GOLES, CAMBIOS, TARJETAS DE LOS JUGADORES SUPLENTES DEL EQUIPO VISITANTE -----------------------

            if (isset($value->estadisticas->titulares_eq_visit)) {

                $estadEqVisit =  $this->EstadisticasResultadosEquipoLocal($JugEqVistAll, $TitularesEqVisit, $SuplentesEqVisit, $GolsJugEqVisit, $MinGolesEqVisit, $CambSalenEqVisit, $CambEntranEqVisit, $MinCambioEqVisit, $tarjAmaEqVisit, $MinTarjAmaEqVisit, $tarjRojaEqVisit, $MinTarjRojaEqVisit);
                // dd($estadEqVisit,$CambSalenEqVisit, $MinCambioEqVisit);

                foreach ($value->estadisticas->titulares_eq_visit  as $key => $titeqLocal) {
                    $value->estadisticas->titulares_eq_visit[$key]->gol = [];
                    $value->estadisticas->titulares_eq_visit[$key]->cambiosale = [];
                    $value->estadisticas->titulares_eq_visit[$key]->amarilla = [];
                    $value->estadisticas->titulares_eq_visit[$key]->roja = [];
                    //----------------------- GOLES DE LOS JUGADORES TITULARES DEL EQUIPO VISITANTE -----------------------
                    if (array_key_exists($titeqLocal->id, $estadEqVisit['goles'])) {
                        $value->estadisticas->titulares_eq_visit[$key]->gol = $estadEqVisit['goles'][$titeqLocal->id];
                    }
                    //----------------------- CAMBIOS QUE SALEN DE LOS JUGADORES TITULARES DEL EQUIPO VISITANTE -----------------------
                    if (array_key_exists($titeqLocal->id, $estadEqVisit['cambiosSalen'])) {
                        $value->estadisticas->titulares_eq_visit[$key]->cambiosale = $estadEqVisit['cambiosSalen'][$titeqLocal->id];
                    }
                    //---------------------- TARJETAS AMARILLAS DE LOS JUGADORES TITULARES DEL EQUIPO VISITANTE -----------------------
                    if (array_key_exists($titeqLocal->id, $estadEqVisit['amarillas'])) {
                        $value->estadisticas->titulares_eq_visit[$key]->amarilla = $estadEqVisit['amarillas'][$titeqLocal->id];
                    }
                    //---------------------- TARJETAS ROJAS DE LOS JUGADORES TITULARES DEL EQUIPO VISITANTE -----------------------
                    if (array_key_exists($titeqLocal->id, $estadEqVisit['rojas'])) {
                        $value->estadisticas->titulares_eq_visit[$key]->roja = $estadEqVisit['rojas'][$titeqLocal->id];
                    }
                }
                //----------------------- GOLES, CAMBIOS, TARJETAS DE LOS JUGADORES SUPLENTES DEL EQUIPO LOCAL -----------------------

                foreach ($value->estadisticas->suplentes_eq_visit  as $key => $supleqLocal) {
                    $value->estadisticas->suplentes_eq_visit[$key]->gol = [];
                    $value->estadisticas->suplentes_eq_visit[$key]->cambioentra = [];
                    $value->estadisticas->suplentes_eq_visit[$key]->amarilla = [];
                    $value->estadisticas->suplentes_eq_visit[$key]->roja = [];
                    //----------------------- GOLES DE LOS JUGADORES SUPLENTES DEL EQUIPO VISITANTE -----------------------
                    if (array_key_exists($supleqLocal->id, $estadEqVisit['goles'])) {
                        $value->estadisticas->suplentes_eq_visit[$key]->gol = $estadEqVisit['goles'][$supleqLocal->id];
                    }
                    //----------------------- CAMBIOS QUE ENTRAN DE LOS JUGADORES SUPLENTES DEL EQUIPO VISITANTE -----------------------
                    if (array_key_exists($supleqLocal->id, $estadEqVisit['cambiosSalen'])) {
                        $value->estadisticas->suplentes_eq_visit[$key]->cambioentra = $estadEqVisit['cambiosSalen'][$supleqLocal->id];
                    }
                    //---------------------- TARJETAS AMARILLAS DE LOS JUGADORES SUPLENTES DEL EQUIPO VISITANTE -----------------------
                    if (array_key_exists($supleqLocal->id, $estadEqVisit['amarillas'])) {
                        $value->estadisticas->suplentes_eq_visit[$key]->amarilla = $estadEqVisit['amarillas'][$supleqLocal->id];
                    }
                    //---------------------- TARJETAS ROJAS DE LOS JUGADORES SUPLENTES DEL EQUIPO VISITANTE -----------------------
                    if (array_key_exists($supleqLocal->id, $estadEqVisit['rojas'])) {
                        $value->estadisticas->suplentes_eq_visit[$key]->roja = $estadEqVisit['rojas'][$supleqLocal->id];
                    }
                }
            }
        }
        $otrosResultados = [];
        if (isset($request->id)) {
            // dd($request->id);
            // $otrosResultados = Resultados::with(['juego.equipo_local', 'juego.equipo_visitante'])->where('id_juego', '<>', $request->id)->get();
            $resul = Resultados::with(['juego'])->where('id', $request->id)->first();

        // dd($resul->juego->id_jornada);
            $otrosResultados = juegos::with([
                'resultado',
                'jornada.categoria',
                'equipo_local',
                'equipo_visitante',
                
            ])->where([['id_jornada', $resul->juego->id_jornada], ['id_categoria', $resul->juego->id_categoria]])->get();
            
            // Resultados::with(['juego.jornada.categoria', 'juego.equipo_local', 'juego.equipo_visitante'])

            //     ->whereHas('juego.jornada', function ($query) use ($request) {
            //         return $query->where('vigente', '=', 1);
            //     })->get();
        }



        return [
            'data' =>  $resultados,
            'otrosResultados' =>  $otrosResultados,
            'jornada' =>  $jornada
        ];
    }


    function ResultadosJornada(Request $request)
    {
        // return $request->all();

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
        })->whereIn('vigente', [0, 1])->get();
        $Categoria = Categoria::all();

        return [
            'jornada' => $jornada,
            'categoria' => $Categoria,
            'data' => $resultados
        ];
    }
}
