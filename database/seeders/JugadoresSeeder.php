<?php

namespace Database\Seeders;

use App\Models\Categoria\Categoria_Equipo;
use App\Models\Equipos\Equipos;
use App\Models\Jugadores\Jugadores;
use App\Models\Jugadores\JugadoresEquipos;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Isset_;

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
        $faker = Faker::create('es_VE');
        $equipos = Equipos::count();
        $cantidadJugad = ($equipos * 12);
        foreach (range(1, $cantidadJugad) as $index) {
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

            $eq = $faker->numberBetween($min = 1, $max = 30);

            $jugEq =  DB::table('equipos')->inRandomOrder()->where('id', '!=', $eq)->count();


            if ($jugEq <= 20) {

                DB::table('jugadores_equipos')->insert([
                    'equipo_id' => $eq,
                    'jugador_id' => $jugador,
                ]);
            }
        }
        $categoria_equipo =  Categoria_Equipo::get();



        foreach ($categoria_equipo as $key => $categ) {
            $jugador =   Jugadores::all();
            foreach ($jugador as $key => $jug) {

                $exisJugador =    JugadoresEquipos::where([['jugador_id', $jug->id], ['categoria_id', $categ->categoria_id], ['equipo_id', $categ->equipo_id]])->first();
                if (!isset($exisJugador)) {

                    $new_jugador =  new JugadoresEquipos;
                    $new_jugador->jugador_id = $jug->id;
                    $new_jugador->equipo_id = $categ->equipo_id;
                    $new_jugador->categoria_id = $categ->categoria_id;
                    $new_jugador->save();
                }
                // else{
                // }
            }
        }
    }
}
