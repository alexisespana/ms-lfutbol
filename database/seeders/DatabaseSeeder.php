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
        $this->call(MenuSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(EquiposSeeder::class);
        $this->call(GruposSeeder::class);
        $this->call(JugadoresSeeder::class);
        $this->call(SedeSeeder::class);
        $this->call(ArbitroSeeder::class);
        // $this->call(JornadaSeeder::class);
        // $this->call(JuegosSeeder::class);
        // $this->call(ResultadosSeeder::class);
        // $this->call(EstadisticasJuegosSeeder::class);
        // $this->call(EstadisticasJornadaSeeder::class);
        // $this->call(PosicionesSeeder::class);
       

    }
}
