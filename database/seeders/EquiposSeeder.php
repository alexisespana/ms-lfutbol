<?php

namespace Database\Seeders;

use App\Models\Categoria\Categoria;
use App\Models\Temporada\Temporada;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

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


        $equipos = (object)[
            ['nombre' => 'VILLA ESPAÑA', 'alias' => 'VIE', 'escudo' => '/VIE.PNG'],
            ['nombre' => 'TORREBLANCA', 'alias' => 'TOB', 'escudo' => '/TOB.PNG'],
            ['nombre' => 'DPTES BRASIL', 'alias' => 'BRA', 'escudo' => '/BRA.PNG'],
            ['nombre' => 'HALCON DEL ORIENTE', 'alias' => 'HAL', 'escudo' => '/HAL.PNG'],
            ['nombre' => 'CARMELITOS', 'alias' => 'CAR', 'escudo' => '/CAR.PNG'],
            ['nombre' => 'APOSTOL SANTIAGO', 'alias' => 'ASA', 'escudo' => '/ASA.PNG'],
            ['nombre' => 'REAL MADRID', 'alias' => 'RMA', 'escudo' => '/RMA.PNG'],
            ['nombre' => 'LO VALLEDOR NORTE', 'alias' => 'VAN', 'escudo' => '/VAN.PNG'],
            ['nombre' => 'DEFENSOR UNIDO', 'alias' => 'DEU', 'escudo' => '/DEU.PNG'],
            ['nombre' => 'LOS LEONES', 'alias' => 'LEO', 'escudo' => '/LEO.PNG'],
            ['nombre' => 'LANUS', 'alias' => 'LAN', 'escudo' => '/LAN.PNG'],
            ['nombre' => 'VILLA ECUADOR', 'alias' => 'VEC', 'escudo' => '/VEC.PNG'],
            ['nombre' => 'BOLDO', 'alias' => 'BOL', 'escudo' => '/BOL.PNG'],
            ['nombre' => 'CAUPOLICAN', 'alias' => 'CAU', 'escudo' => '/CAU.PNG'],
            ['nombre' => 'REAL FRANCIA', 'alias' => 'RFR', 'escudo' => '/RFR.PNG'],
            ['nombre' => 'VILLABLANCA', 'alias' => 'VIB', 'escudo' => '/VIB.PNG'],

            ['nombre' => 'ATAHULPA', 'alias' => 'ATA', 'escudo' => '/ATA.PNG'],
            ['nombre' => 'J.M CARO', 'alias' => 'JMC', 'escudo' => '/JMC.PNG'],
            ['nombre' => 'TRIANGULO', 'alias' => 'TRI', 'escudo' => '/TRI.PNG'],
            ['nombre' => 'CONDORES DE CHILE', 'alias' => 'NOG', 'escudo' => '/NOG.PNG'],
            ['nombre' => 'KENEDY', 'alias' => 'KEN', 'escudo' => '/KEN.PNG'],
            ['nombre' => 'POBLACION LAS REJAS', 'alias' => 'PRJ', 'escudo' => '/PRJ.PNG'],
            ['nombre' => 'REAL OLIMPIA', 'alias' => 'ROL', 'escudo' => '/ROL.PNG'],
            ['nombre' => 'CAPITAN GALVEZ', 'alias' => 'CGA', 'escudo' => '/CGA.PNG'],
            ['nombre' => 'H HERRERA', 'alias' => 'HER', 'escudo' => '/HER.PNG'],
            ['nombre' => 'ESTRELLA SAN JOSE', 'alias' => 'ESJ', 'escudo' => '/EST.PNG'],
            ['nombre' => 'POBLACION NOGALES', 'alias' => 'PNO', 'escudo' => '/PNO.PNG'],
            ['nombre' => 'POBLACION SANTIAGO', 'alias' => 'PSA', 'escudo' => '/PSA.PNG'],
            ['nombre' => 'JUVENTUD AYSEN', 'alias' => 'JAY', 'escudo' => '/JAY.PNG'],
            ['nombre' => 'CORHABIT', 'alias' => 'COR', 'escudo' => '/COR.PNG'],

        ];
        // foreach (range(1, 10) as $index) {
        $temporada = Temporada::where('vigente', 1)->first()->id;

        foreach ($equipos as $key => $value) {

            $idEquipo = DB::table('equipos')->insertGetId([
                'temporada_id' => $temporada, // 'b',
                'nombre' => $value['nombre'], // 'b',
                'abr' => $value['alias'],
                'descripcion' => $faker->paragraph,
                'escudo' => $value['escudo'],
                'color' => $faker->hexColor,
                'color_text' => $faker->hexColor,

            ]);
        }
    }
}
