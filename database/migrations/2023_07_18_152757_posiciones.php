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
            $table->integer('posicion');
            $table->unsignedBigInteger('id_equipo');
            $table->unsignedBigInteger('id_categoria');
            $table->integer('jugados');
            $table->integer('ganados');
            $table->integer('empate');
            $table->integer('perdidos');
            $table->integer('goles_favor');
            $table->integer('goles_contra');
            $table->integer('dif_goles');
            $table->integer('puntos');
            $table->timestamps();
            $table->foreign('id_equipo')->references('id')->on('equipos');
            $table->foreign('id_categoria')->references('id')->on('categoria');

            
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
