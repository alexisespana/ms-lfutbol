<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grupos = [
            'Grupo A',
            'Grupo B',
            'Grupo C',
        ];
        // foreach (range(1, 10) as $index) {
        foreach ($grupos as $key => $value) {
            DB::table('grupos')->insert([
                'nombre' => $value,
            ]);
        }
    }
}
