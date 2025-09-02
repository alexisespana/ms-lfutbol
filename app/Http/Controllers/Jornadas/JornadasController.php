<?php

namespace App\Http\Controllers\Jornadas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CategoriasTraits\CategoriasTraits;
use App\Models\Categoria\Categoria;
use App\Models\Categoria\Categoria_Equipo;
use App\Models\cod_tipo\cod_tipo;
use App\Models\Equipos\Equipos;
use App\Models\grupos;
use App\Models\Jornada\Jornada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JornadasController extends Controller
{
    use CategoriasTraits;

    public function ListaJornadas(Request $request)
    {

        $jornadas = $this->Categoria($request->id_categoria);
        
        return $jornadas;
    }
    public function listarJornadas(Request $request)
    {
        $jornadas = Jornada::with(
            'temporada',
            'categoria.grupo_categoria.grupos',
            'juegos.grupo_categoria.categorias',
            'juegos.grupo_categoria.grupos',
            'juegos.equipo_local',
            'juegos.equipo_visitante',
            'juegos.status',
            'juegos.sede',
            'juegos.resultados.estadisticas_resultados',
            'status'
        )
            ->when(isset($request->id_jornada), function ($q) use ($request) {
                return $q->where('id',  $request->id_jornada);
            })
            ->whereRelation('categoria', 'id', $request->id_categoria)
            ->get();
        $status = cod_tipo::where('status', 1)->get();

        return response()->json(['status' => $status, 'jornadas' => $jornadas]);
    }

    public function modificarJornadas(Request $request)
    {
        try {

            $activo = cod_tipo::where('id', 1)->first()->id;

            $jornadaActiva = Jornada::where([['id_categoria', $request->id_categoria], ['status', $activo]])->count();

            // return $jornadaActiva;

            if ($jornadaActiva > 0) {
                return response()->json(['message' => 'Ya se encuentra una jornada activa para esta Categoría.', 'status' => 500]);
            }

            $jornada = Jornada::find($request->id_jornada);

            $jornada->fecha = $request->fecha;
            $jornada->status = $request->status;

            $jornada->save();

            $message = 'La <b>' . $jornada->nombre . '</b> se han modificado Exitosamente..!';
            $status = 200;
        } catch (\Exception $e) {


            DB::rollBack();
            Log::error('Ha ocurrido un error al Amodificar la jornada ====> ' . $e);
            $message = 'Ha ocurrido un error al Amodificar la jornada!';
            $status = 500;
        }

        DB::commit();

        return response()->json(['message' => $message, 'status' => $status]);
    }
}
