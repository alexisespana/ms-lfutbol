<?php

namespace App\Http\Controllers\Equipos;

use App\Http\Controllers\Controller;
use App\Models\Categoria\Categoria;
use App\Models\Equipos\Equipos;
use App\Models\Jugadores\JugadoresEquipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EquiposController extends Controller
{
    //
    public function index(Request $request)
    {

        // return $request->all();

        $equipos = Equipos::with(['categoria'])
            ->when(isset($request->id_equipo), function ($q) use ($request) {
                return $q->where('id',  $request->id_equipo);
            })
            ->orderBy('nombre', 'asc')->get();
        return $equipos;
    }
    public function CrearEquipos(Request $request)
    {
        try {
            $idEquipo = Equipos::create([
                'nombre' => strtoupper($request->nombre), // 'b',
                'abr' => strtoupper($request->alias),
                'descripcion' => $request->descripcion,
                'escudo' => 'http://ms-futbol.test/',
                'color' => strtoupper($request->color1),
                'color_text' => strtoupper($request->color2),

            ]);
            // Log::error('ID DEL EQUIPO ====> ' . $idEquipo->id);


            if (isset($request->categorias)) {

                foreach ($request->categorias as $key => $value) {
                    # code...
                    DB::table('categoria_equipo')->insert([
                        'categoria_id' => $value,
                        'equipo_id' => $idEquipo->id,
                    ]);
                }
            }
            $message = 'El Equipo se ha Creado exitosamente..!';
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('Ha ocurrido un error al crear el Equipo ====> ' . $e);
            $message = 'Ha ocurrido un error al crear el Equipo!';
            $status = 500;


            return response()->json(['message' => $message, 'status' => $status], 500);
        }

        DB::commit();
        $status = 200;

        return response()->json(['message' => $message, 'status' => $status]);
    }
    function editarEquipos(Request $request)
    {

        // return $request->all();
        try {
            $equipo = Equipos::find($request->idEquipo)
                ->update([
                    'nombre' => strtoupper($request->nombre),
                    'abr' => strtoupper($request->alias),
                    'descripcion' => $request->descripcion,
                    'color' => strtoupper($request->color1),
                    'color_text' => strtoupper($request->color2),
                    // 'usuario_m' => Auth::user()->username,


                ]);

            DB::table('categoria_equipo')->where('equipo_id', $request->idEquipo)->delete();

            if (isset($request->categorias)) {

                foreach ($request->categorias as $key => $value) {
                    # code...
                    DB::table('categoria_equipo')->insert([

                        'categoria_id' => $value,
                        'equipo_id' => $request->idEquipo,

                    ]);
                }
            }

            $message = 'El Equipo se ha modificado exitosamente..!';
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('Ha ocurrido un error al editar el Equipo ====> ' . $e);
            $message = 'Ha ocurrido un error al editar el Equipo!';
            $status = 500;


            return response()->json(['message' => $message, 'status' => $status], 500);
        }

        DB::commit();
        $status = 200;

        return response()->json(['message' => $message, 'status' => $status]);
    }
    function registrarJugadoresEquipos(Request $request)
    {
        try {

            // return $request->all
            foreach ($request->id_categoria as $key => $value) {
                // EN CASO DE QUE NO SE AGREGRE NINUNG JUGADOR PARA EL EQUIPO EN UNA CATEGORIA
                if ($request->jugadores[$key] != null) {


                    foreach ($request->jugadores[$key] as $keys => $jugadores) {

                        $jugador =  JugadoresEquipos::where([['jugador_id', $jugadores], ['equipo_id', $request->equipo_id], ['categoria_id', $value]])->count();
                        if ($jugador < 1) {


                            $JugadoresEquipos = new JugadoresEquipos;

                            $JugadoresEquipos->jugador_id = $jugadores;
                            $JugadoresEquipos->equipo_id = $request->equipo_id;
                            $JugadoresEquipos->categoria_id = $value;

                            $JugadoresEquipos->save();
                        }
                    }
                }
            }
            $message = 'Se han agregados todos los jugadores al equipos, en las categoria seleccionadas';
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('Ha ocurrido un error al crear los jugadores de los equipos ====> ' . $e);
            $message = 'Ha ocurrido un error al crear los jugadores de los equipos!';
            $status = 500;


            return response()->json(['message' => $message, 'status' => $status], 500);
        }

        DB::commit();
        $status = 200;

        return response()->json(['message' => $message, 'status' => $status]);
    }
}
