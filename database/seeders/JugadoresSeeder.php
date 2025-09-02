<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JugadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        foreach (range(1, 200) as $index) {
            $jugador = DB::table('jugadores')->insertGetId([
                'nombre' => $faker->name,
                'apellidos' => $faker->lastName,
                'cedula' => $faker->phoneNumber,
                'posicion' => $faker->randomElement($array = array('Defensa', 'Medio Campo', 'Delantero')),
                'fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'telefono' => $faker->phoneNumber,
                'direccion' => $faker->address,
                'imagen' => $faker->imageUrl($width = 640, $height = 480) // 'http://lorempixel.com/640/480/',
                // 'imagen' => storage_path().'/img/Carabobo/Jugadores/none.png',
            ]);

            $eq = $faker->numberBetween($min = 1, $max = 10);

            $jugEq =  DB::table('equipos')->inRandomOrder()->where('id', '!=', $eq)->count();


            if ($jugEq <= 20) {

                DB::table('jugadores_equipos')->insert([
                    'equipo_id' => $eq,
                    'jugador_id' => $jugador,
                ]);
            }
        }
    }
}
