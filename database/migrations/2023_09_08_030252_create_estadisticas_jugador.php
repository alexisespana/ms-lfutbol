<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadisticasJugador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadisticas_jugador', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipo_id');
            $table->unsignedBigInteger('jugador_id');
            $table->integer('partidos')->nullable();
            $table->integer('goles')->nullable();
            $table->integer('titularidad')->nullable();
            $table->integer('cambio')->nullable();
            $table->integer('tarjetas_amarilla')->nullable();
            $table->integer('tarjetas_roja')->nullable();
            $table->integer('año')->nullable();
            $table->timestamps();
            $table->foreign('equipo_id')->references('id')->on('equipos');
            $table->foreign('jugador_id')->references('id')->on('jugadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estadisticas_jugador');
    }
}
