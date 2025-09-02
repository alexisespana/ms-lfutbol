<?php

namespace App\Http\Controllers\Traits\EstadisticasResultadosTrait;


trait EstadisticasResultadosTrait
{
    function EstadisticasResultadosEquipoLocal($JugEqlocalAll, $TitularesEqLocal, $SuplentesEqLocal, $GolsJugEqLocal, $MinGolesEqLocal, $CambSalenEqLocal, $CambEntranEqLocal, $MinCambioEqLocal, $tarjAmaEqLocal, $MinTarjAmaEqLocal, $tarjRojaEqLocal, $MinTarjRojaEqLocal)
    {

        foreach ($JugEqlocalAll as $keyjug => $jug) {
            //----------------------- PARA EXTRAER TODOS LOS GOLES DEL EQUIPO LOCAL -----------------------
            $golesEncont[] = [];
            if (count($GolsJugEqLocal) > 0) {
                foreach ($GolsJugEqLocal as $keygol => $gol) {
                    if (!array_key_exists($gol, $golesEncont)) {
                        $golesEncont[$gol] = [];
                    }

                    if ($gol == $jug) {
                        foreach ($TitularesEqLocal as $key => $titu) {
                            if ($titu->id == $gol) {
                                array_push($golesEncont[$gol],  $MinGolesEqLocal[$keygol]);
                            }
                        }
                        foreach ($SuplentesEqLocal as $key => $titu) {
                            if ($titu->id == $gol) {
                                array_push($golesEncont[$gol],  $MinGolesEqLocal[$keygol]);
                            }
                        }
                    }
                }
            }

            //----------------------- PARA EXTRAER TODOS LOS JUGADORES QUE SALEN DEL EQUIPO LOCAL -----------------------
            // dd($TitularesEqLocal,$CambSalenEqLocal,$MinCambioEqLocal);
            $cambiosSalen[] = [];
            if (isset($CambSalenEqLocal)) {
                foreach ($CambSalenEqLocal as $keySalen => $Csalen) {
                    $cambiosSalen[] = [];
                    if (!array_key_exists($Csalen, $cambiosSalen)) {
                        $cambiosSalen[$Csalen] = [];
                    }
                    if ($Csalen == $jug) {
                        foreach ($TitularesEqLocal as $key => $titu) {
                            if ($titu->id == $Csalen) {
                                array_push($cambiosSalen[$Csalen],  $MinCambioEqLocal[$keySalen]);
                            }
                        }
                    }
                }
            }
            //----------------------- PARA EXTRAER TODOS LOS JUGADORES QUE ENTRAN DEL EQUIPO LOCAL -----------------------

            $cambiosEntran[] = [];
            if (isset($CambEntranEqLocal)) {
                foreach ($CambEntranEqLocal as $keySalen => $Csalen) {
                    if (!array_key_exists($Csalen, $cambiosEntran)) {
                        $cambiosEntran[$Csalen] = [];
                    }
                    if ($Csalen == $jug) {

                        foreach ($SuplentesEqLocal as $key => $titu) {
                            if ($titu->id == $Csalen) {
                                array_push($cambiosEntran[$Csalen],  $MinCambioEqLocal[$keySalen]);
                            }
                        }
                    }
                }
            }

            //----------------------- PARA EXTRAER TODAS LAS AMARILLAS DE LOS JUGADORES EN EL EQUIPO LOCAL -----------------------
            $amaEncontradas[] = [];
            if (isset($tarjAmaEqLocal)) {

                foreach ($tarjAmaEqLocal as $keyAma => $ama) {
                    if (!array_key_exists($ama, $amaEncontradas)) {
                        $amaEncontradas[$ama] = [];
                    }

                    if ($ama == $jug) {
                        foreach ($TitularesEqLocal as $key => $titu) {
                            if ($titu->id == $ama) {
                                array_push($amaEncontradas[$ama],  $MinTarjAmaEqLocal[$keyAma]);
                            }
                        }
                        foreach ($SuplentesEqLocal as $key => $titu) {
                            if ($titu->id == $ama) {
                                array_push($amaEncontradas[$ama],  $MinTarjAmaEqLocal[$keyAma]);
                            }
                        }
                    }
                }
            }
              //----------------------- PARA EXTRAER TODAS LAS AMARILLAS DE LOS JUGADORES EN EL EQUIPO LOCAL -----------------------
              $rojaEncontradas[] = [];
              if (isset($tarjRojaEqLocal)) {
  
                  foreach ($tarjRojaEqLocal as $keyRoja => $roja) {
                      if (!array_key_exists($roja, $rojaEncontradas)) {
                          $rojaEncontradas[$roja] = [];
                      }
  
                      if ($roja == $jug) {
                          foreach ($TitularesEqLocal as $key => $titu) {
                              if ($titu->id == $roja) {
                                  array_push($rojaEncontradas[$roja],  $MinTarjRojaEqLocal[$keyRoja]);
                              }
                          }
                          foreach ($SuplentesEqLocal as $key => $titu) {
                              if ($titu->id == $roja) {
                                  array_push($rojaEncontradas[$roja],  $MinTarjRojaEqLocal[$keyRoja]);
                              }
                          }
                      }
                  }
              }

            
        }

        // dd(array_filter($golesEncont));


        $EstadEqLocal = [
            'goles' => array_filter($golesEncont),
            'cambiosSalen' => array_filter($cambiosSalen),
            'cambiosEntran' => array_filter($cambiosEntran),
            'amarillas' => array_filter($amaEncontradas),
            'rojas' => array_filter($rojaEncontradas),
        ];
        // dd($EstadEqLocal);

        return $EstadEqLocal;
    }
}
