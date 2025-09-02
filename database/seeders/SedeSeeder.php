<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SedeSeeder extends Seeder
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
        foreach (range(1, 2) as $index) {
            DB::table('sede')->insert([
                'nombre' => $faker->name,
                'direccion' => $faker->address,
               
            ]);
        }
    }
}
