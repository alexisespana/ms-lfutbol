<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use App\Models\Categoria\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoriasController extends Controller
{
    function Categorias(Request $request)
    {

        $categorias = Categoria::with(['equipos'])
            ->when(isset($request->id_categoria), function ($q) use ($request) {
                return $q->where('id',  $request->id_categoria);
            })->where('vigente', 1)->get();

        return $categorias;
    }
    function crearCateogorias(Request $request)
    {
        try {
            $categoria = Categoria::insertGetId([
                'nombre' => $request->nombre,
                'alias' => $request->alias,
                // 'usuario' =>  $request->usuario,
            ]);
            if ($categoria && isset($request->equipos)) {

                foreach ($request->equipos as $key => $value) {
                    # code...
                    DB::table('categoria_equipo')->insert([

                        'categoria_id' => $categoria,
                        'equipo_id' => $value

                    ]);
                }
            }
            $message = 'La Categoría se ha regitrado exitosamente..!';
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('ha ocurrido un error al insertar el producto ====> ' . $e);
            $message = 'Ha ocurrido un error al crear el producto!';
            $status = 500;


            return response()->json(['message' => $message, 'status' => $status], 500);
        }

        DB::commit();
        $status = 200;

        return response()->json(['message' => $message, 'status' => $status]);
    }

    function editarCategoria(Request $request)
    {

        // return $request->all();
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
