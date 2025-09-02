<?php

namespace App\Http\Controllers\Traits\CrearTablaPosicionesTraits;

use App\Models\Jornada\Jornada;
use App\Models\Jornada\JornadaCategoria;
use App\Models\Posiciones\Posiciones;
use Illuminate\Support\Facades\Log;

trait CrearTablaPosicionesTraits
{
    public function TablaPosiciones($equipos, $idgrupo_categoria)
    {

        $jornadaGrupo = JornadaCategoria::where('categoria_id', $idgrupo_categoria)->first()->id;
        foreach ($equipos as $key => $value) {

            $posiciones = new Posiciones;

            $posiciones->id_equipo = $value;
            $posiciones->idgrupo_categoria = $idgrupo_categoria;
            $posiciones->id_jornada = $jornadaGrupo;
            $posiciones->posicion = $key + 1;
            $posiciones->jugados = '0';
            $posiciones->ganados = '0';
            $posiciones->empate = '0';
            $posiciones->perdidos = '0';
            $posiciones->goles_favor = '0';
            $posiciones->goles_contra = '0';
            $posiciones->dif_goles = '0';
            $posiciones->puntos = '0';
            $posiciones->save();
        }
    }

    public function ModificarTablaPosiciones($id_equipo, $id_categoria)
    {

        // Log::alert("message");

        // return  $id_equipo;


        foreach ($id_equipo as $key => $value) {


            # code...
            $puntos = 0;

            if ($value['ganados'] == 1 && $value['empate'] == 0 && $value['perdidos'] == 0) {
                $puntos = 3;
            } else if ($value['empate'] == 1 && $value['ganados'] == 0 &&  $value['perdidos'] == 0) {
                $puntos = 1;
            } else {
                $puntos = 0;
            }

            $equipo =  Posiciones::where([['id_jornada', $id_categoria->id_jornada], ['id_equipo', $value['id_equipo']], ['idgrupo_categoria', $id_categoria->id_categoria]])->get();


            if ($equipo->count() > 0) {
                // return response()->json(['message' => $equipo, 'status' => 500]);
                // Log::alert($equipo);


                $sumaGoles =  Posiciones::where([['idgrupo_categoria', $id_categoria->id_categoria], ['id_equipo', $value['id_equipo']]]);



                $new_posiciones = Posiciones::find($equipo->first()->id);
                $new_posiciones->jugados = $equipo->first()->jugados + 1;
                $new_posiciones->ganados = $equipo->sum('ganados') + $value['ganados'];
                $new_posiciones->empate = $equipo->sum('empate') + $value['empate'];
                $new_posiciones->perdidos = $equipo->sum('perdidos') + $value['perdidos'];
                $new_posiciones->goles_favor = $equipo->sum('goles_favor') + $value['goles_favor'];
                $new_posiciones->goles_contra = $equipo->sum('goles_contra') + $value['goles_contra'];
                $new_posiciones->perdidos = $equipo->sum('perdidos') + $value['perdidos'];
                $new_posiciones->puntos = $equipo->sum('puntos') + $puntos;
                $new_posiciones->dif_goles = $id_categoria->id_jornada == 1 ? ($value['goles_favor'] - $value['goles_contra']) : ($sumaGoles->sum('goles_favor') - $sumaGoles->sum('goles_contra'));

                $new_posiciones->save();



                // Log::alert($equipo->select('goles_favor')->first(), $value['id_equipo'] . '--- ' . $id_categoria->id_categoria);
            } else {

                $equipos_categoria =  Posiciones::where('idgrupo_categoria', $id_categoria->id_categoria)->where('id_equipo', '!=', $value['id_equipo'])->get();
                foreach ($equipos_categoria as $key => $equipo_encontrado) {

                    $equipos_categoria = new Posiciones;
                    $equipos_categoria->id_equipo = $equipo_encontrado->id_equipo;
                    $equipos_categoria->idgrupo_categoria = $id_categoria->id_categoria;
                    $equipos_categoria->posicion = 1;
                    $equipos_categoria->id_jornada = $id_categoria->id_jornada;
                    $equipos_categoria->jugados = $equipo_encontrado->jugados;
                    $equipos_categoria->ganados = $equipo_encontrado->ganados;
                    $equipos_categoria->empate = $equipo_encontrado->empate;
                    $equipos_categoria->perdidos = $equipo_encontrado->perdidos;
                    $equipos_categoria->goles_favor = $equipo_encontrado->goles_favor;
                    $equipos_categoria->goles_contra = $equipo_encontrado->goles_contra;
                    $equipos_categoria->puntos = $equipo_encontrado->puntos;
                    $equipos_categoria->dif_goles = $equipo->sum('goles_favor') + $equipo->sum('goles_contra');
                    $equipos_categoria->save();
                }





                $equipo =  Posiciones::where([['id_equipo', $value['id_equipo']], ['idgrupo_categoria', $id_categoria->id_categoria]]);

                $new_posiciones = new Posiciones;
                $new_posiciones->id_equipo = $value['id_equipo'];
                $new_posiciones->posicion = 1;
                $new_posiciones->idgrupo_categoria = $id_categoria->id_categoria;
                $new_posiciones->id_jornada = $id_categoria->id_jornada;
                $new_posiciones->jugados = $equipo->sum('jugados') + 1;
                $new_posiciones->ganados = $equipo->sum('ganados') - +$value['ganados'];
                $new_posiciones->empate = $equipo->sum('empate') + $value['empate'];
                $new_posiciones->perdidos = $equipo->sum('perdidos') + $value['perdidos'];
                $new_posiciones->goles_favor = $equipo->sum('goles_favor') + $value['goles_favor'];
                $new_posiciones->goles_contra = $equipo->sum('goles_contra') + $value['goles_contra'];
                $new_posiciones->puntos = $equipo->sum('puntos') + $puntos;
                $new_posiciones->dif_goles = $equipo->sum('goles_favor') - $equipo->sum('goles_contra');
                $new_posiciones->save();
            }
        }
        // $posiciones =  Posiciones::where([['idgrupo_categoria', $id_categoria->id_categoria], ['id_jornada', $id_categoria->id_jornada]])->orderBy('puntos', 'desc');

        // $posicion = $this->ordenarEquiposBurbuja($posiciones->get());



        // foreach ($posicion as $key => $posi) {
        //     $posi->update([
        //         'posicion' => ($key + 1),
        //     ]);
        // }

        // Log::alert($posicion);
    }

    function ordenarEquiposBurbuja($equipos)
    {
        $ordenados = $equipos;
        $n = count($ordenados);

        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                $a = $ordenados[$j];
                $b = $ordenados[$j + 1];

                $dgA = $a->goles_favor - $a->goles_contra;
                $dgB = $b->goles_favor - $b->goles_contra;

                $intercambiar = false;

                if ($a->puntos < $b->puntos) {
                    $intercambiar = true;
                } elseif ($a->puntos === $b->puntos) {
                    if ($a->jugados > $b->jugados) {
                        $intercambiar = true;
                    } elseif ($a->jugados === $b->jugados) {
                        if ($dgA < $dgB) {
                            $intercambiar = true;
                        } elseif ($dgA === $dgB) {
                            if ($a->goles_favor < $b->goles_favor) {
                                $intercambiar = true;
                            } elseif ($a->goles_favor === $b->goles_favor) {
                                if ($a->goles_contra > $b->goles_contra) {
                                    $intercambiar = true;
                                }
                            }
                        }
                    }
                }

                if ($intercambiar) {
                    $temp = $ordenados[$j];
                    $ordenados[$j] = $ordenados[$j + 1];
                    $ordenados[$j + 1] = $temp;
                }
            }
        }

        return $ordenados;
    }

    // public static function burbuja($collection)
    // {
    //     for ($i = 1; $i <= count($collection) - 1; $i++) {
    //         for ($j = 1; $j <= count($collection) - $i; $j++) {
    //             $primerEquipo = $collection[$j - 1];
    //             $proxEquipo = $collection[$j];

    //             if ($primerEquipo->puntos < $proxEquipo->puntos) { //ordena de acuerdo a quien tiene mas puntos
    //                 $collection[$j - 1] = $proxEquipo;
    //                 $collection[$j] = $primerEquipo;
    //             } else  if ($primerEquipo->puntos === $proxEquipo->puntos) { //En caso de que tengan las misma cantida de puntos

    //                 // 1------ Se ordena de acuerdo a quien tiene menos partidos jugados
    //                 if ($primerEquipo->jugados > $proxEquipo->jugados) {
    //                     $collection[$j - 1] = $proxEquipo;
    //                     $collection[$j] = $primerEquipo;
    //                 }

    //                 // 2------ Se ordena de acuerdo a quien tiene mejor diferencia de goles
    //                 else if ($primerEquipo->dif_goles < $proxEquipo->dif_goles) {
    //                     $collection[$j - 1] = $proxEquipo;
    //                     $collection[$j] = $primerEquipo;
    //                 }
    //                 // 3------ Se ordena de acuerdo a quien tiene  mas goles a favor
    //                 else if ($primerEquipo->goles_favor < $proxEquipo->goles_favor) {
    //                     $collection[$j - 1] = $proxEquipo;
    //                     $collection[$j] = $primerEquipo;
    //                 }
    //                 // 4------ Se ordena de acuerdo a quien tiene  menos goles a en contra
    //                 else if ($primerEquipo->goles_contra > $proxEquipo->goles_contra) {
    //                     $collection[$j - 1] = $proxEquipo;
    //                     $collection[$j] = $primerEquipo;
    //                 }
    //             }
    //         }
    //     }

    //     return $collection;
    // }
}
