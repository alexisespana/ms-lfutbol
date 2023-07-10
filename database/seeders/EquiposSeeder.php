<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;



class EquiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $index) {


            DB::table('equipos')->insert([
                'nombre' => $faker->randomElement($array = array ('equipo')).' '.$index, // 'b',
                'descripcion' => $faker->paragraph,
                'escudo' => $faker->imageUrl(640, 480, 'animals', true),
               
            ]);
        }
    }
}
