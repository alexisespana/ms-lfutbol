<?php

namespace Database\Seeders;

use App\Models\Juegos\juegos;
use App\Models\Resultados\Resultados;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EstadisticasJuegosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $juegos = juegos::where('status', '1')->get();

        foreach ($juegos as $index) {


            $resultados = Resultados::where('id_juego',  $index->id)->first();

            $jugEqLocalTit =  DB::table('jugadores_equipos')->where('equipo_id', $index->equipo_local)->inRandomOrder()->take(11)->pluck('jugador_id');
            $jugEqLocalSupl =  DB::table('jugadores_equipos')->where('equipo_id', $index->equipo_local)->whereNotIn('jugador_id', $jugEqLocalTit)->inRandomOrder()->take(11)->pluck('jugador_id');

            // Log::error('AQUI '. json_decode($jugEqLocalTit,true));

            $jugEqVisitTit =  DB::table('jugadores_equipos')->where('equipo_id', $index->equipo_visitante)->inRandomOrder()->take(11)->pluck('jugador_id');
            $jugEqVisitSupl =  DB::table('jugadores_equipos')->where('equipo_id', $index->equipo_visitante)->whereNotIn('jugador_id', $jugEqVisitTit)->inRandomOrder()->take(11)->pluck('jugador_id');


            $goles_local = DB::table('jugadores_equipos')->where('equipo_id', $index->equipo_local)->whereIn('jugador_id', $jugEqLocalTit)->orwhereIn('jugador_id', $jugEqLocalSupl)->take($resultados->goles_local)->pluck('jugador_id');
            $min_goles_local = DB::table('jugadores_equipos')->where('equipo_id', $index->equipo_local)->inRandomOrder()->take($resultados->goles_local)->pluck('jugador_id');
            $goles_visitante = DB::table('jugadores_equipos')->where('equipo_id', $index->equipo_visitante)->whereIn('jugador_id', $jugEqVisitTit)->orwhereIn('jugador_id', $jugEqVisitTit)->take($resultados->goles_visitante)->pluck('jugador_id');
            $min_goles_visitante = DB::table('jugadores_equipos')->where('equipo_id', $index->equipo_visitante)->inRandomOrder()->take($resultados->goles_visitante)->pluck('jugador_id');
        //    ----------------PARA LOS JUGADORES DEL EQUIPO LOCAL -------------------------------
            $cambiosEntranEqLocal = [];
            $cambiosSalenEqLocal = [];
            $min_cambio_eq_local = [];
            $tarjeta_ama_eq_local = [];
            $min_ama_eq_local = [];
            $tarjeta_roja_eq_local = [];
            $min_roja_eq_local = [];
            for ($i = 1; $i <=  $faker->numberBetween($min = 0, $max = count($jugEqLocalTit)); $i++) {
                array_push($cambiosEntranEqLocal, $faker->randomElement($array = $jugEqLocalSupl));
                array_push($cambiosSalenEqLocal, $faker->randomElement($array = $jugEqLocalTit));
                array_push($min_cambio_eq_local, $faker->numberBetween($min = 1, $max = 90));
            }
            for ($i = 1; $i <=   $faker->numberBetween($min = 0, $max = 9); $i++) {
                array_push($tarjeta_ama_eq_local, $faker->randomElement($array = $jugEqLocalTit));
                array_push($min_ama_eq_local, $faker->numberBetween($min = 1, $max = 90));
            }
            for ($i = 1; $i <=   $faker->numberBetween($min = 0, $max = 9); $i++) {
                array_push($tarjeta_roja_eq_local, $faker->randomElement($array = $jugEqLocalTit));
                array_push($min_roja_eq_local, $faker->numberBetween($min = 1, $max = 90));
            }

            //    ----------------PARA LOS JUGADORES DEL EQUIPO VISITANTE -------------------------------
            $cambiosEntranEqVisit = [];
            $cambiosSalenEqVisit = [];
            $min_cambio_eq_visit = [];
            $tarjeta_ama_eq_visit = [];
            $min_ama_eq_visit = [];
            $tarjeta_roja_eq_visit = [];
            $min_roja_eq_visit = [];
            for ($i = 1; $i <=  $faker->numberBetween($min = 0, $max = count($jugEqVisitTit)); $i++) {
                array_push($cambiosEntranEqVisit, $faker->randomElement($array = $jugEqVisitSupl));
                array_push($cambiosSalenEqVisit, $faker->randomElement($array = $jugEqVisitTit));
                array_push($min_cambio_eq_visit, $faker->numberBetween($min = 1, $max = 90));
            }
            for ($i = 1; $i <=   $faker->numberBetween($min = 0, $max = 9); $i++) {
                array_push($tarjeta_ama_eq_visit, $faker->randomElement($array = $jugEqVisitTit));
                array_push($min_ama_eq_visit, $faker->numberBetween($min = 1, $max = 90));
            }
            for ($i = 1; $i <=   $faker->numberBetween($min = 0, $max = 9); $i++) {
                array_push($tarjeta_roja_eq_visit, $faker->randomElement($array = $jugEqVisitTit));
                array_push($min_roja_eq_visit, $faker->numberBetween($min = 1, $max = 90));
            }
            // Log::error(json_encode($cambiosEntran));
            DB::table('estadisticas_juegos')->insert([
                'juego_id' => $index->id,
                'titulares_eq_local' => $jugEqLocalTit,
                'suplentes_eq_local' => $jugEqLocalSupl,
                'cambio_entra_eq_local' => count($jugEqLocalSupl) > 0 ? json_encode($cambiosEntranEqLocal) : '[]',
                'cambio_sale_eq_local' =>   count($jugEqLocalTit) > 0 ? json_encode($cambiosSalenEqLocal) : '[]',
                'min_cambio_eq_local' => json_encode($min_cambio_eq_local),
                'goles_eq_local' => $goles_local,
                'min_goles_eq_local'  => $min_goles_local,
                'tarjeta_ama_eq_local' => json_encode($tarjeta_ama_eq_local),
                'min_ama_eq_local'  => json_encode($min_ama_eq_local),
                'tarjeta_roja_eq_local' => json_encode($tarjeta_roja_eq_local),
                'min_roja_eq_local'  => json_encode($min_roja_eq_local),


                'titulares_eq_visit' => $jugEqVisitTit,
                'suplentes_eq_visit' => $jugEqVisitSupl,
                'cambio_entra_eq_visit' => count($jugEqVisitSupl) > 0 ? json_encode($cambiosEntranEqVisit) : '[]',
                'cambio_sale_eq_visit' => count($jugEqVisitTit) > 0 ? json_encode($cambiosSalenEqVisit) : '[]',
                'min_cambio_eq_visit' => json_encode($min_cambio_eq_visit),

                'goles_eq_visit' => $goles_visitante,
                'min_goles_eq_visit'  => $min_goles_visitante,
                'tarjeta_ama_eq_visit' => json_encode($tarjeta_ama_eq_visit),
                'min_ama_eq_visit'  => json_encode($min_ama_eq_visit),
                'tarjeta_roja_eq_visit' => json_encode($tarjeta_roja_eq_visit),
                'min_roja_eq_visit'  => json_encode($min_roja_eq_visit),

            ]);
        }
    }
}
