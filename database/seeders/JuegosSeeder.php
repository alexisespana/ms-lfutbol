<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JuegosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        foreach (range(1, 7) as $index) {
            DB::table('juegos')->insert([
                'equipo_local' => DB::table('equipos')->inRandomOrder()->first()->id,
                'equipo_visitante' => DB::table('equipos')->inRandomOrder()->first()->id,
                'fecha' => $faker->dateTimeBetween($startDate = 'now', $endDate = 'now', $timezone = null),
                'hora' => $faker->time($format = 'H:i:s', $max = 'now'),
                'sede' => DB::table('sede')->inRandomOrder()->first()->id,
                'arbitro' => DB::table('arbitro')->inRandomOrder()->first()->id,
            ]);
        }
    }
}
