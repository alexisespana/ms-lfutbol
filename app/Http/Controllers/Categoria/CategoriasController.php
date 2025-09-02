<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CategoriasTraits\CategoriasTraits;
use App\Http\Controllers\Traits\CrearTablaPosicionesTraits\CrearTablaPosicionesTraits;
use App\Models\Categoria\Categoria;
use App\Models\Categoria\Categoria_Equipo;
use App\Models\grupos;
use App\Models\Grupos\Grupos_Categorias;
use App\Models\Jornada\Jornada;
use App\Models\Jornada\JornadaCategoria;
use App\Models\Temporada\Temporada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoriasController extends Controller
{
    use CategoriasTraits, CrearTablaPosicionesTraits;
    function Categorias(Request $request)
    {
        $categorias = $this->Categoria($request->id_categoria);
        return $categorias;
    }
    function crearCateogorias(Request $request)
    {
        try {
            $categoria = Categoria::insertGetId([
                'nombre' => $request->nombre,
                'alias' => $request->alias,
                'grupos' => isset($request->grupo) ? 1 : 0,
                'cant_grupos' => isset($request->n_grupo) ? $request->n_grupo : 0,
                // 'usuario' =>  $request->usuario,
            ]);



            // PARA CREAR LOS GRUPOS
            if (($request->n_grupo) != 0) {


                for ($i = 0; $i <= $request->n_grupo; $i++) {

                    $grupos = grupos::where('nombre', 'grupo ' . $i);

                    if ($grupos->count() < 1) {
                        $grupos = grupos::insertGetId([
                            'nombre' => 'grupo ' . $i,
                        ]);
                    }
                }
                $grupos = grupos::skip(1)->take($request->n_grupo)->get('id');
                // Log::error('grupos encontrados ====> ' . $grupos);
                foreach ($grupos as $key => $grup) {

                    # code...
                    Grupos_Categorias::insert([
                        'categoria_id' => $categoria,
                        'grupo_id' => $grup->id
                    ]);
                }
                //ACA SE AGREGAN LOS EQUIPOS A LA CATEGORIA PERO NO SE LE ASIGNAN LOS GRUPOS
                foreach ($request->equipos as $key => $value) {

                    Categoria_Equipo::insert([
                        'categoria_id' => $categoria,
                        'equipo_id' => $value,
                    ]);
                }
                if (($request->idavuelta == true)) {
                    $cantJornada = ((count($request->equipos) / $request->n_grupo) * 2) - 2;
                } else {
                    $cantJornada = count($request->equipos);
                }

                //  PARA AGREGAR LAS JORNADA POR CATEGORIAS Y GRUPOS
                $grupos =   Grupos_Categorias::where('categoria_id', $categoria)->get();



                # code...
                for ($i = 1; $i <= $cantJornada; $i++) {
                    foreach ($grupos as $key => $grup) {
                        $temporada = Temporada::where('vigente', 1)->first()->id;
                        $jornadas = Jornada::insertGetId([
                            'id_temporada' => $temporada,
                            'id_categoria' => $categoria,
                            'nombre' => 'Jornada ' . $i,
                            'fecha' => '',
                            'status' => 2,
                        ]);

                        JornadaCategoria::insert([
                            'jornada_id' => $jornadas,
                            'categoria_id' => $grup->id
                        ]);
                    }
                }
            } else {
                $grupos = grupos::where('nombre', 'grupo 0')->count();
                if ($grupos < 1) {

                    $grupos = grupos::insertGetId([
                        'nombre' => 'grupo 0',
                    ]);
                } else {
                    $grupos = grupos::where('nombre', 'grupo 0')->first()->id;
                }
                $idgrupo_categoria = Grupos_Categorias::insertGetId([
                    'categoria_id' => $categoria,
                    'grupo_id' => $grupos
                ]);
                foreach ($request->equipos as $key => $value) {

                    Categoria_Equipo::insert([
                        'categoria_id' => $categoria,
                        'equipo_id' => $value,
                        'grupo_id' => $grupos
                    ]);
                }

                if (($request->idavuelta == true)) {
                    $cantJornada = (count($request->equipos) * 2) - 2;
                } else {
                    $cantJornada = count($request->equipos);
                }

                //  PARA AGREGAR LAS JORNADA POR CATEGORIAS Y GRUPOS
                $grupos =   Grupos_Categorias::where('categoria_id', $idgrupo_categoria)->get();



                # code...
                for ($i = 1; $i <= $cantJornada; $i++) {
                    foreach ($grupos as $key => $grup) {
                        $temporada = Temporada::where('vigente', 1)->first()->id;
                        $jornadas = Jornada::insertGetId([
                            'id_temporada' => $temporada,
                            'id_categoria' => $categoria,
                            'nombre' => 'Jornada ' . $i,
                            'fecha' => '',
                            'status' => 2,
                        ]);

                        JornadaCategoria::insert([
                            'jornada_id' => $jornadas,
                            'categoria_id' => $grup->id
                        ]);
                    }
                }



                // PARA CREAR LA TABLA DE POSICIONES DEL GRUPO CREADO.
                $this->TablaPosiciones($request->equipos, $idgrupo_categoria);
            }






            $message = 'La Categoría se ha regitrado exitosamente..!';
            $status = 200;
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('ha ocurrido un error al Crear la Categoría ====> ' . $e);
            $message = 'ha ocurrido un error al Crear la Categoría!';
            $status = 500;


            return response()->json(['message' => $message, 'status' => $status], 500);
        }

        DB::commit();

        return response()->json(['message' => $message, 'status' => $status]);
    }

    function editarCategoria(Request $request)
    {        // return $request->all();
        try {
            $categoria = Categoria::find($request->idCategoria)
                ->update([
                    'nombre' => $request->nombre,
                    'alias' => $request->alias,
                    // 'usuario_m' => Auth::user()->username,
                ]);

            DB::table('categoria_equipo')->where('categoria_id', $request->idCategoria)->delete();

            foreach ($request->equipos as $key => $value) {
                # code...
                DB::table('categoria_equipo')->insert([

                    'categoria_id' => $request->idCategoria,
                    'equipo_id' => $value

                ]);
            }


            $message = 'La Categoría se ha modificado exitosamente..!';
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('Ha ocurrido un error al editar el la categoria ====> ' . $e);
            $message = 'Ha ocurrido un error al editar el la categoria!';
            $status = 500;


            return response()->json(['message' => $message, 'status' => $status], 500);
        }

        DB::commit();
        $status = 200;

        return response()->json(['message' => $message, 'status' => $status]);
    }
    function deleteCategoria(Request $request)
    {

        // return $request->all();
        try {
            Categoria::find($request->id_categoria)
                ->update([
                    'vigente' => 0,
                    // 'usuario_m' => Auth::user()->username,


                ]);

            DB::table('categoria_equipo')->where('categoria_id', $request->id_categoria)->delete();



            $message = 'La Categoría se ha Eliminado exitosamente..!';
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('Ha ocurrido un error al editar el la categoria ====> ' . $e);
            $message = 'Ha ocurrido un error al editar el la categoria!';
            $status = 500;


            return response()->json(['message' => $message, 'status' => $status], 500);
        }

        DB::commit();
        $status = 200;

        return response()->json(['message' => $message, 'status' => $status]);
    }
}
