<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Posiciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posiciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_equipo');
            $table->unsignedBigInteger('idgrupo_categoria');
            $table->unsignedBigInteger('id_jornada');
            $table->integer('posicion')->nullable();
            $table->integer('jugados')->nullable();
            $table->integer('ganados')->nullable();
            $table->integer('empate')->nullable();
            $table->integer('perdidos')->nullable();
            $table->integer('goles_favor')->nullable();
            $table->integer('goles_contra')->nullable();
            $table->integer('dif_goles')->nullable();
            $table->integer('puntos')->nullable();
            $table->timestamps();
            $table->foreign('id_equipo')->references('id')->on('equipos');
            $table->foreign('idgrupo_categoria')->references('id')->on('grupo_categoria');
            $table->foreign('id_jornada')->references('id')->on('jornada');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posiciones');
    }
}
