<?php

namespace Database\Seeders;

use App\Models\EstadisticasJornada\EstadisticasJornada;
use App\Models\Jornada\Jornada;
use App\Models\Juegos\juegos;
use App\Models\Jugadores\Jugadores;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

class EstadisticasJornadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $juegosPortada =[];
        foreach (range(1, 9) as $index) {
            $jornada = Jornada::with(['juegos.equipo_local.jugadores'])->where('vigente', 1)->first();

        // Log::alert($jornada->juegos);

            $juegoID = $jornada->juegos[$faker->numberBetween($min = 1, $max = 3)]->id;
            
            if (!in_array($juegoID, $juegosPortada)) {
                array_push($juegosPortada, $juegoID);
            }
            
        }
        // $juegoID = $jornada->juegos[$faker->numberBetween($min = 1, $max = 7)]->id;
        // $juegoID2 = $jornada->juegos[$faker->numberBetween($min = 1, $max = 7)]->id;
        // $juegoID3 = $jornada->juegos[$faker->numberBetween($min = 1, $max = 7)]->id;

        $juego = juegos::with(['equipo_local.jugadores'])->where('id', $juegoID)->first();

        // Log::alert('aqui => '.$juegoID.' => ' .$jornada);

        EstadisticasJornada::create([
            'jornada_id' => $jornada->id,
            'portada' =>'['.implode(",", $juegosPortada).']',
            'jugador_semana' => '[' . Jugadores::where('id', '!=', '0')->inRandomOrder()->first()->id. ']',
            'portero_semana' => '[' . Jugadores::where('id', '!=', '0')->inRandomOrder()->first()->id. ']',
            'jugador_torneo' => '[' . Jugadores::where('id', '!=', '0')->inRandomOrder()->first()->id. ']',
            'portero_torneo' => '[' . Jugadores::where('id', '!=', '0')->inRandomOrder()->first()->id. ']',
        ]);

        
    }
}
