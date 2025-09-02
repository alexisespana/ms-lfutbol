<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemporadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('temporada')->insert([
            'nombre' => 'temporada 1',
            'ano' => '2024',
            'vigente' => 1

        ]);

    }
}
