<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EquiposSeeder::class);
        $this->call(JugadoresSeeder::class);
        $this->call(SedeSeeder::class);
        $this->call(ArbitroSeeder::class);
        $this->call(JuegosSeeder::class);
       

    }
}
