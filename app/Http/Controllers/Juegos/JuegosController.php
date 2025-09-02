<?php

namespace App\Http\Controllers\Juegos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CategoriasTraits\CategoriasTraits;
use App\Models\Arbitro\Arbitro;
use App\Models\Jornada\Jornada;
use App\Models\Juegos\juegos;
use App\Models\Jugadores\Jugadores;
use App\Models\Jugadores\JugadoresEquipos;
use App\Models\Sede\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JuegosController extends Controller
{
    use CategoriasTraits;
    public function index(Request $request)
    {

        // return $request->all() ;

        $categorias = $this->Categoria($request->id_categoria);
        $juegos = juegos::with(
            [
                'jornada',
                'status',
                'resultados.estadisticas_resultados',
                'grupo_categoria',
                'sede',
                'grupo_categoria.categorias',
                'grupo_categoria.grupos',
                'equipo_local',
                'equipo_visitante'
            ]
        )
            ->when($request, function ($query) use ($request) {
                if (isset($request->id_jornada)) {
                    $query->where('jornada', $request->jornada);
                }
            })
            ->when($request, function ($query) use ($request) {
                if (isset($request->id_juego)) {
                    $query->where('id', $request->id_juego);
                }
            })->get()
            ->map(function ($juegos, $index) {

                $juegos->equipo_local->jugadores =
                    JugadoresEquipos::with(['jugadores'])
                    ->where([['equipo_id', $juegos->equipo_local->id], ['categoria_id', $juegos->id_categoria]])
                    ->get('jugador_id');

                $juegos->equipo_visitante->jugadores =
                    JugadoresEquipos::with(['jugadores'])
                    ->where([['equipo_id', $juegos->equipo_visitante->id], ['categoria_id', $juegos->id_categoria]])
                    ->get('jugador_id');

                    //EN CASO DE QUE EL JUEGO YA TENGA RESULTADO CREADOS------------
                if (isset($juegos->resultados->estadisticas_resultados)) {
                    // Log::alert();

                    $juegos->resultados->estadisticas_resultados->titulares_eq_local = Jugadores::whereIn('id', collect(explode(',',$juegos->resultados->estadisticas_resultados->titulares_eq_local)))->get('nombre');
                }

                return $juegos;
            });


        //  SI NO HAY CATEGORIAS CREADAS SE MUESTRA EL MENSAJE DE EEROR
        // if (isset($categorias->original['message'])) {
        //     return $categorias;
        // }

        return response()->json(['juegos'=>$juegos, 'categorias' => $categorias]);
    }
    public function crearJuegos(Request $request)
    {
        $categorias = $this->Categoria($request->id_categoria);
        $fecha_activa = Jornada::where('status',1)->first();
        $sedes = Sede::where('status', 1)->get(['id', 'nombre', 'direccion', 'status']);
        $arbitros = Arbitro::where('status', 1)->get(['id', 'nombre', 'apellidos', 'status']);
        return ['categorias' => $categorias, 'sedes' => $sedes, 'arbitros' => $arbitros,'fecha_activa' => $fecha_activa];
    }
    public function registrarJuegos(Request $request)
    {
        // return $request->all();


        foreach ($request->juegos as $key => $juegos) {
            // Log::alert($request->juegos);

            try {
                $juego = new juegos;


                $juego->status = Jornada::where('id', $juegos['id_jornada'])->first()->status;
                $juego->id_jornada = $juegos['id_jornada'];
                $juego->id_categoria = $juegos['id_categoria'];
                $juego->id_equipo_local = $juegos['equipo_local'];
                $juego->id_equipo_visitante = $juegos['equipo_visitante'];
                $juego->fecha = Jornada::where('status', 1)->first()->fecha;
                $juego->hora = $juegos['hora'];
                $juego->sede = $juegos['sede'];
                $juego->arbitro = $juegos['arbitro'];

                $juego->save();
            } catch (\Exception $e) {


                DB::rollBack();
                Log::error('Ha ocurrido un error al crear el juego ====> ' . $e);
                $message = 'Ha ocurrido un error al crear el juego!';
                $status = 500;
                DB::commit();
                return response()->json(['message' => $message, 'status' => $status]);
            }
        }
        return response()->json(['message' => 'se ha registrado todos los juegos', 'status' => 200]);
    }
}
