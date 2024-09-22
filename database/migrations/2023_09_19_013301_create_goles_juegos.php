<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGolesJuegos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goles_juegos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resultado_id');
            $table->unsignedBigInteger('jugador_id');
            $table->integer('min_gol');
            $table->foreign('resultado_id')->references('id')->on('resultados');
            $table->foreign('jugador_id')->references('id')->on('jugadores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goles_juegos');
    }
}
