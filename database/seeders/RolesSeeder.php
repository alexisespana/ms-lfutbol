<?php

namespace Database\Seeders;

use App\Models\Menu\Menu;
use App\Models\Roles\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = [
            "Administrador",


        ];

        // // $countries = json_decode($json,true);
        // $jsons = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true);
        // Log::error($json);


        foreach ($json as $key => $value) {



            $rol =  Roles::insertGetId([
                'nombre' => $value,
                'descripcion' => 'administrador del sistema, el cual tendrá control total de todos los Módulos del Sistema.',
            ]);

            if(Roles::where('id', $rol)->pluck('nombre')->first()== 'Administrador'){

                foreach (Menu::all() as $key => $menu) {
                    
                    
                    DB::table('role_menu')
                    ->insert([
                        'role_id' => $rol,
                        'menu_id' => $menu->id,
                        
                    ]);
                }
            }
        }
    }
}
