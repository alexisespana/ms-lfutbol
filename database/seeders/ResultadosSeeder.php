<?php

namespace Database\Seeders;

use App\Models\Juegos\juegos;
use App\Models\ReportajeResultados\ReportajeResultados;
use App\Models\Resultados\Resultados;
use App\Models\Goleadores\Goleadores;
use App\Models\GolesJuegos\GolesJuegos;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ResultadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        // SI EL JUEGO TIENE STATUS 1 SIGNIFICA QUE EL JUEGO FINALIZO
        $juegos = juegos::all();
        foreach ($juegos as $key => $value) {
                $id = Resultados::insertGetId([
                    'id_juego' => $value->id,
                    'goles_local' => $faker->numberBetween(0, 6),
                    'goles_visitante' => $faker->numberBetween(0, 6),

                ]);

                $resultado = Resultados::where('id', '=', $id)->first();
                $equipoLocal =  DB::table('equipos')->inRandomOrder()->where('id', $value->equipo_local)->first()->nombre;
                $equipoVisitante =  DB::table('equipos')->inRandomOrder()->where('id', $value->equipo_visitante)->first()->nombre;
                $titulo = "";
                if ($resultado->goles_local > $resultado->goles_visitante) {

                    $titulo = $equipoLocal . " le ganó a " . $equipoVisitante . ", " . $resultado->goles_local . " goles a " . $resultado->goles_visitante . '.';
                    // $value->equipo_local
                } else if ($resultado->goles_local < $resultado->goles_visitante) {

                    $titulo = $equipoVisitante . " le ganó a " . $equipoLocal . ", " . $resultado->goles_visitante . " goles a " . $resultado->goles_local . '.';
                    // $value->equipo_local
                } else {
                    $titulo = $equipoVisitante . " empató con " . $equipoLocal . ", " . $resultado->goles_visitante . " goles a " . $resultado->goles_local . '.';
                }
                $goleLocal = [];
                $goleVist = [];
                $golesMinEqLocal = [];
                $golesMinEqVist = [];

                // Log::alert($value->equipo_local);
                if ($resultado->goles_local > 0) {

                    // $jugadoreLocal = Jugadores::where('equipo_id', $value->equipo_local)->limit($resultado->goles_local)->get();

                    $jugadoreLocal = DB::table('jugadores_equipos')->where('equipo_id', $value->equipo_local)->limit($resultado->goles_local)->get();
                    foreach ($jugadoreLocal as $key => $golesLoc) {

                        $detalles_goles = GolesJuegos::insert([
                            'resultado_id' => $id,
                            'jugador_id' => $golesLoc->id,
                            'min_gol' => $faker->numberBetween(1, 90)
                        ]);

                        $Goleadores = Goleadores::where('jugador_id', $golesLoc->id)->first();

                        if (is_null($Goleadores)) {
                            $Goleadores =  Goleadores::insert([
                                'jugador_id' => $golesLoc->id,
                                'cant_goles' => 1
                            ]);
                        } else {
                            DB::table('goleadores')->where('jugador_id', $golesLoc->id)->update(['cant_goles' => $Goleadores->cant_goles + 1]);
                        }
                    }
                }
                if ($resultado->goles_visitante > 0) {
                    // $jugadoreVisitant = Jugadores::where('equipo_id', $value->equipo_visitante)->limit($resultado->goles_visitante)->get();
                    $jugadoreVisitant = DB::table('jugadores_equipos')->where('equipo_id', $value->equipo_visitante)->limit($resultado->goles_visitante)->get();
                    foreach ($jugadoreVisitant as $key => $golesVis) {
                        $detalles_goles = GolesJuegos::insert([
                            'resultado_id' => $id,
                            'jugador_id' => $golesVis->id,
                            'min_gol' => $faker->numberBetween(1, 90)
                        ]);
                        $Goleadores = Goleadores::where('jugador_id', $golesVis->id)->first();

                        if (is_null($Goleadores)) {
                            $Goleadores =  Goleadores::insert([
                                'jugador_id' => $golesVis->id,
                                'cant_goles' => 1
                            ]);
                        } else {
                            // $Goleadores->jugador_id = $golesVis->id;

                            DB::table('goleadores')->where('jugador_id', $golesVis->id)->update(['cant_goles' => $Goleadores->cant_goles + 1]);
                        }
                    }
                }

                ReportajeResultados::insert([
                    'id_resultado' => $id,
                    'titulo' => $titulo,
                    'descripcion' => $faker->text,
                    'img_principal' => $faker->imageUrl(640, 480, 'cats', true, 'Faker', false),
                    'img1' => $faker->imageUrl(640, 480),
                    'img2' => $faker->imageUrl(640, 480),
                ]);
            
        }


        // -- PARA MODIFICAR LA POSICION DE LOS GOLEADORES Y SU EFECTIVIDAD

        $Goleadores = Goleadores::with(['jugador.equipo', 'goles_partidos'])->get();


        foreach ($Goleadores as $key => $value) {
            $TotalPartidos = count($value->goles_partidos);
            $goles = $value->cant_goles;

            $promedio = ($goles / $TotalPartidos);
            DB::table('goleadores')->where('id', $value->id)->update(
                [
                    'efectividad' => $goles . $TotalPartidos,
                    'lugar' => 1
                ]
            );

            # code...
        }
    }
}
