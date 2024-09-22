<?php

namespace Database\Seeders;

use App\Models\Categoria\Categoria;
use App\Models\Equipos\Equipos;
use App\Models\Jornada\Jornada;
use App\Models\Juegos\juegos;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

class JuegosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $jornada = Jornada::all();
        $equipos = Equipos::all();
        $faker = Faker::create();
        foreach ($jornada as $jornd) {
            $categoria = Categoria::all();
            foreach ($categoria as $categ) {

                // $idEquipo = Equipos::inRandomOrder()->first()->id;
                $idEquipo = Equipos::with(['categoria'])
                ->whereHas('categoria', function ($query) use ($categ) {
                    return $query->where('categoria_id', '=', $categ->id);
                })->get();


                foreach ($idEquipo as $key => $idequipo) {
                    # code...
                    
                    DB::table('juegos')->insert([
                        'status' => $faker->numberBetween(0, 2),
                        'id_jornada' => $jornd->id,
                        'id_categoria' => $categ->id,
                        'equipo_local' => Equipos::with(['categoria']) ->whereHas('categoria', function ($query) use ($categ){
                            return $query->where('categoria_id', '=', $categ->id);
                        })->inRandomOrder()->where('id', '!=', $idequipo->id)->first()->id,
                        'equipo_visitante' => $idequipo->id,
                        'fecha' => $faker->dateTimeBetween($startDate = 'now', $endDate = 'now', $timezone = null),
                        'hora' => $faker->time($format = 'H:i:s', $max = 'now'),
                        'sede' => DB::table('sede')->inRandomOrder()->first()->id,
                        'arbitro' => DB::table('arbitro')->inRandomOrder()->first()->id,
                    ]);
                }
            }
        }
    }
}
