<?php

namespace Database\Seeders;

use App\Models\Categoria\Categoria;
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


        $equipos = [
            'VILLA ESPAÑA',
            'TORREBLANCA',
            'DPTES BRASIL',
            'HALCON DEL ORIENTE',
            'CARMELITOS',
            'APOSTOL SANTIAGO',
            'REAL MADRID',
            'LO VALLEDOR NORTE',
            'DEFENSOR UNIDO',
            'LOS LEONES',
            'LANUS',
            'VILLA ECUADOR',
            'BOLDO',
            'CAUPOLICAN',
            'REAL FRANCIA',
            'VILLABLANCA'
        ];
        // foreach (range(1, 10) as $index) {
        foreach ($equipos as $key => $value) {

            $idEquipo = DB::table('equipos')->insertGetId([
                'nombre' => $value, // 'b',
                'abr' => $faker->stateAbbr,
                'descripcion' => $faker->paragraph,
                'escudo' => $faker->imageUrl(640, 480, 'animals', true),
                'color' => $faker->hexColor,
                'color_text' => $faker->hexColor,

            ]);

            $categoria = Categoria::take($faker->numberBetween($min = 1, $max = 7))->get();
            foreach ($categoria as $key => $value) {
                # code...
                DB::table('categoria_equipo')->insert([
                    'categoria_id' => $value->id,
                    'equipo_id' => $idEquipo,
                ]);
            }
        }
    }
}
