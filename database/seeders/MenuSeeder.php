<?php

namespace Database\Seeders;

use App\Models\Menu\Menu;
use App\Models\Menu\MenuPadre;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $menu_padre = [
            [
                "nombre" => "Inicio",
                "icono" => "home",
                "orden" => "1"
            ],
           
            [
                "nombre" => "Categorias",
                "icono" => "equalizer",
                "orden" => "2"
            ],
            [
                "nombre" => "Grupos",
                "icono" => "fas fa-layer-group",
                "orden" => "3"
            ],
            [
                "nombre" => "Equipos",
                "icono" => "view_list",
                "orden" => "4"
            ],
            [
                "nombre" => "Juegos",
                "icono" => "view_list",
                "orden" => "5"
            ],
            [
                "nombre" => "Resultados",
                "icono" => "fas fa-futbol",
                "orden" => "6"
            ],
            [
                "nombre" => "Posiciones",
                "icono" => "fas fa-futbol",
                "orden" => "7"
            ],
            [
                "nombre" => "Jugadores",
                "icono" => "swap_horiz",
                "orden" => "8"
            ],
            [
                "nombre" => "Jornadas",
                "icono" => "swap_horiz",
                "orden" => "9"
            ],

        ];
        $menu =  [
            [
                "tipo" => "1",
                "nombre" => "Inicio",
                "href" => "/dashboard",
                "id_menupadre" => "1",
                "orden" => "1"
            ],

          
            [
                "tipo" => "2",
                "nombre" => "Lista de Categorias",
                "href" => "/Categorias/Lista",
                "id_menupadre" => "2",
                "orden" => "1"
            ],
            [
                "tipo" => "2",
                "nombre" => "Lista de grupos",
                "href" => "/Grupos/Lista",
                "id_menupadre" => "3",
                "orden" => "1"
            ],
            [
                "tipo" => "2",
                "nombre" => "Lista de Equipos",
                "href" => "/Equipos/Lista",
                "id_menupadre" => "4",
                "orden" => "1"
            ],
            [
                "tipo" => "2",
                "nombre" => "Lista de Juegos",
                "href" => "/Juegos/Lista",
                "id_menupadre" => "5",
                "orden" => "2"
            ],
            [
                "tipo" => "2",
                "nombre" => "Crear Juegos",
                "href" => "/Juegos/Crear",
                "id_menupadre" => "5",
                "orden" => "1"
            ],
            [
                "tipo" => "2",
                "nombre" => "Resultados Juegos",
                "href" => "/Resultados/Juegos",
                "id_menupadre" => "6",
                "orden" => "1"
            ],
            [
                "tipo" => "2",
                "nombre" => "Tabla de Posiciones",
                "href" => "/Posiciones/Tabla",
                "id_menupadre" => "7",
                "orden" => "1"
            ],


            [
                "tipo" => "2",
                "nombre" => "Lista de Jugadores",
                "href" => "/Jugadores/Lista",
                "id_menupadre" => "8",
                "orden" => "1"
            ],
            [
                "tipo" => "2",
                "nombre" => "Lista Jornadas",
                "href" => "/Jornadas/Lista",
                "id_menupadre" => "9",
                "orden" => "1"
            ],
        ];


        // // $countries = json_decode($json,true);
        // $jsons = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true);
        // Log::error($json);


        foreach ($menu_padre as $key => $value) {
            MenuPadre::create([
                'nombre' => $value['nombre'],
                'icono' => $value['icono'],
                'orden' => $value['orden'],
            ]);
        }
        foreach ($menu as $key => $value) {


            Menu::create([
                'tipo' => $value['tipo'],
                'nombre' => $value['nombre'],
                'href' => $value['href'],
                'id_menupadre' => $value['id_menupadre'],
                'orden' => $value['orden'],
            ]);
        }
    }
}
