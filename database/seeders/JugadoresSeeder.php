<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

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
        foreach (range(1, 10) as $index) {
            DB::table('jugadores')->insert([
                'nombre' => $faker->name,
                'apellidos' => $faker->lastName,
                'cedula' => $faker->phoneNumber,
                'equipo' =>  $faker->numberBetween($min = 1, $max = 7),
                'posicion' => $faker->randomElement($array = array ('Defensa','Medio Campo','Delantero')),
                'fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'direccion' => $faker->address,
                'telefono' => $faker->phoneNumber,
            ]);
        }
    }
}
