<?php

namespace App\Http\Controllers\Grupos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CrearTablaPosicionesTraits\CrearTablaPosicionesTraits;
use App\Models\Grupos\Grupos_Categorias;
use App\Models\Posiciones\Posiciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GruposController extends Controller
{
    use CrearTablaPosicionesTraits;
    public function CrearGrupos(Request $request)
    {
        // Log::info($request->all());
        try {

            //SE LE BORRAN TODOS LOS GRUPOS A LOS EQUIPOS DE ESA CATEGORIA.
            DB::table('categoria_equipo')
                ->where('categoria_id', $request->idCategoria)
                ->update([
                    'grupo_id' => null
                ]);

            foreach ($request->idEquipos as $key => $equipo) {
                $idEquipos = array_map('intval', explode(',', $equipo));



                # code...
                DB::table('categoria_equipo')
                    ->where('categoria_id', $request->idCategoria)
                    ->whereIn('equipo_id', $idEquipos)
                    ->update([
                        'grupo_id' => $request->idGrupos[$key]
                    ]);



                $idgrupo_categoria = Grupos_Categorias::where('categoria_id', $request->idCategoria)
                    ->where('grupo_id',  $request->idGrupos[$key])->first()->id;

                // PARA CREAR LA TABLA DE POSICIONES DEL GRUPO CREADO.
                $this->TablaPosiciones($idEquipos, $idgrupo_categoria);
            }





            // ]);
            $message = 'Los Equipos se han asignado al Grupo Exitosamente..!';
            $status = 200;
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('Ha ocurrido un error al Asignar los Equipos al Grupo ====> ' . $e);
            $message = 'Ha ocurrido un error al Asignar los Equipos al Grupo!';
            $status = 500;
            DB::commit();
        }


        return response()->json(['message' => $message, 'status' => $status]);
    }
}
