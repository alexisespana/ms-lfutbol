<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuegos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juegos', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->unsignedBigInteger('id_jornada');
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('equipo_local');
            $table->unsignedBigInteger('equipo_visitante');
            $table->string('fecha');
            $table->string('hora');
            $table->unsignedBigInteger('sede');
            $table->unsignedBigInteger('arbitro');
            $table->timestamps();

            $table->foreign('id_jornada')->references('id')->on('jornada');
            $table->foreign('id_categoria')->references('id')->on('categoria');
            $table->foreign('sede')->references('id')->on('sede');
            $table->foreign('arbitro')->references('id')->on('arbitro');
            $table->foreign('equipo_local')->references('id')->on('equipos');
            $table->foreign('equipo_visitante')->references('id')->on('equipos');

        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('juegos');
    }
}
