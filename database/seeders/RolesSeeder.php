<?php

namespace Database\Seeders;

use App\Models\Roles\Roles;
use Illuminate\Database\Seeder;

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
            "Administador",
            "Vendedor",


        ];

        // // $countries = json_decode($json,true);
        // $jsons = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true);
        // Log::error($json);


        foreach ($json as $key => $value) {



          $rol=  Roles::insertGetId([
                'nombre' => $value,
                'descripcion' => 'creado',
            ]);

            // foreach (Menu::all() as $key => $menu) {
            //     # code...
                
                
                
                
            //     DB::table('user_role')
            //     ->insert([
            //         'user_id' => $menu->id,
            //         'role_id' => $rol,
                    
            //     ]);
            // } 
        }
    }
}
