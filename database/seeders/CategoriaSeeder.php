<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $categorias = [
            'Categoría Sub-8',
            'Categoría Sub-10',
            'Categoría Sub-12',
            'Categoría Sub-14',
            'Categoría Sub-16',
            'Categoría Libre',
            'Categoría Veterano',
        ];
        // foreach (range(1, 10) as $index) {
        foreach ($categorias as $key => $value) {


            DB::table('categoria')->insert([
                'nombre' => $value,
                'alias' => str_replace('Categoría ','',$value),
            ]);
        }
    }
}
