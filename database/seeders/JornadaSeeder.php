<?php

namespace Database\Seeders;

use App\Models\Categoria\Categoria;
use App\Models\Jornada\Jornada;
use App\Models\Temporada\Temporada;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class JornadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $id_temporada = Temporada::insertGetId([
            'nombre' => 'Copa primer campeonato de prueba',
            'vigente' => 1,

        ]);
        $faker = Faker::create();

        $categoria = Categoria::all();
        foreach ($categoria as $categ) {

            foreach (range(1, 7) as $index) {

                $jorndVigente =  Jornada::with(['categoria'])->whereHas('categoria', function ($query) use ($categ) {
                    return $query->where('id', '=', $categ->id);
                })->count();
                DB::table('jornada')->insert([
                    'id_temporada' => $id_temporada,
                    'id_categoria' => $categ->id,
                    'nombre' => 'fecha ' . ($index),
                    'fecha' => Carbon::now(),
                    'vigente' => $jorndVigente == 0 ? $faker->randomElement($array = [0, 1, 2]) : $faker->randomElement($array = [0, 2]),

                ]);
            }
        }
    }
}
