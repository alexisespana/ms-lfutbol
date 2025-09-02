<?php

namespace Database\Seeders;

use App\Models\Categoria\Categoria;
use App\Models\Posiciones\Posiciones;
use App\Models\Resultados\Resultados;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PosicionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public  function orden(array $collection)
    {
        $n = count($collection);
        for ($i = 1; $i <= $n - 1; $i++) {
            for ($j = 1; $j <= $n - $i; $j++) {
                $item = $collection[$j - 1];
                $nextItem = $collection[$j];

                if ($item > $nextItem) {
                    $collection[$j - 1] = $nextItem;
                    $collection[$j] = $item;
                }
            }
        }

        return $collection;
    }
    public function run()
    {
        //

        $faker = Faker::create();

        $categoria = Categoria::with(['equipos'])->get();
        foreach ($categoria as $key => $eq) {
            foreach ($eq->equipos as $key1 => $equipos) {

                Posiciones::create([
                    'posicion' => $faker->randomDigitNot(0),
                    'id_equipo' => $equipos->id,
                    'id_categoria' => $eq->id,
                    'jugados' => 0,
                    'ganados' => 0,
                    'empate' => 0,
                    'perdidos' => 0,
                    'goles_favor' => 0,
                    'goles_contra' => 0,
                    'dif_goles' => 0,
                    'puntos' => 0,



                ]);
            }
        }
        $resultado = Resultados::with(['juego.categoria', 'juego.equipo_local', 'juego.equipo_visitante'])->get();

        foreach ($resultado as $key => $resultados) {
            $empate = "es para que no cambie la tabla de posiciones cuando el resultado es un empate";

            // Log::alert('AQUIIIIIIII ====================> '.$resultados->juego->equipo_local);
            if ($resultados->goles_local > $resultados->goles_visitante) {
                $jugados = 1;
                $ganados = 1;
                $goles_anotados = $resultados->goles_local;
                $goles_recibidos = $resultados->goles_visitante;
                $equipo = $resultados->juego->equipo_local;
                $puntos = 3;

                // ++++
            }
            if ($resultados->goles_local < $resultados->goles_visitante) {
                $jugados = 1;
                $ganados = 1;
                $goles_anotados = $resultados->goles_visitante;
                $goles_recibidos = $resultados->goles_local;
                $equipo = $resultados->juego->equipo_visitante;
                $puntos = 3;

                // ++++++++++++++++
            } else {
                // $puntos = 1;
                // $goles_anotados = $resultados->goles_local;

                $empate =  ""; //empataron y no actualizo la tabla de;
            }

            if ($empate == "") {


                $eq = Posiciones::where("id_equipo", $equipo)->first();

                // Log::alert('AQUIIIIIIII ====================> '.
                //     ' goles local =>  '.$resultados->goles_local.
                //        ' goles_visitante => ' .$resultados->goles_visitante.
                //        ' equipo ganador => '.$equipo
                //     );
                // $resultados->goles_local > $resultados->goles_visitantes.$eq->jugados + $jugados));


                $eqjugados = ($eq->jugados + $jugados);
                $eqganados = ($eq->ganados + $ganados);
                $eqgoles_favor = ($eq->goles_favor + $goles_anotados);
                $eqgoles_contra = ($eq->goles_contra + $goles_recibidos);
                $eqpuntos = ($eq->puntos + $puntos);

                Posiciones::where("id_equipo", $equipo)->update([
                    'jugados' => $eqjugados,
                    'ganados' => $eqganados,
                    'goles_favor' => $eqgoles_favor,
                    'goles_contra' => $eqgoles_contra,
                    'puntos' => $eqpuntos,
                ]);
            }
        }

        $collection = [30, 20, 10, 5, 0];
        $ordered = $this->orden($collection);

        Log::alert($ordered);
    }
}
