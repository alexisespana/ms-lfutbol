<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class ArbitroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 4) as $index) {
            DB::table('arbitro')->insert([
                'nombre' => $faker->name,
                'apellidos' => $faker->lastName(),
                
            ]);
        }
    }
}
