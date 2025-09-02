<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJugadoresEquipos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jugadores_equipos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jugador_id');
            $table->unsignedBigInteger('equipo_id');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('jugador_id')->references('id')->on('jugadores');
            $table->foreign('equipo_id')->references('id')->on('equipos');
            $table->foreign('categoria_id')->references('id')->on('categoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jugadores_equipos');
    }
}
