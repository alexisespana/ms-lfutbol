<?php

namespace Database\Seeders;

use App\Models\cod_tipo\cod_tipo;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class CodtipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $codTipo = [
            [
                'cod_padre' => '01',
                'cod_tipo' => '1',
                'nombre'=> 'Activo',
                'color' => 'success',
                'icons' => '',
            ],
            [
                'cod_padre' => '02',
                'cod_tipo' => '2',
                'nombre'=> 'Pendiente',
                'color' => 'warning',
                'icons' => '',
            ],
            [
                'cod_padre' => '03',
                'cod_tipo' => '3',
                'nombre'=> 'Finalizado',
                'color' => 'info',
                'icons' => '',
            ],
            [
                'cod_padre' => '04',
                'cod_tipo' => '4',
                'nombre'=> 'Supendido',
                'color' => 'danger',
                'icons' => '',
            ]
        ];
        // foreach (range(1, 10) as $index) {
        foreach ($codTipo as $key => $value) {


           $codTipo= new cod_tipo;
           $codTipo->cod_padre = $value['cod_padre'];
           $codTipo->cod_tipo = $value['cod_tipo'];
           $codTipo->nombre = $value['nombre'];
           $codTipo->save();



        }
    }
}
