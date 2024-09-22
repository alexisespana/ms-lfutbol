<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EstadisticasJornada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadisticas_jornada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jornada_id');
            $table->string('portada');
            $table->string('jugador_semana');
            $table->string('portero_semana');
            $table->string('jugador_torneo');
            $table->string('portero_torneo');
            $table->timestamps();

            $table->foreign('jornada_id')->references('id')->on('jornada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estaadisticas_jornada');
    }
}
