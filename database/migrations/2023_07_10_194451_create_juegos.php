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
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('id_jornada');
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_equipo_local');
            $table->unsignedBigInteger('id_equipo_visitante');
            $table->string('fecha');
            $table->string('hora');
            $table->unsignedBigInteger('sede');
            $table->unsignedBigInteger('arbitro');
            $table->timestamps();

            // $table->foreign('id_jornada')->references('id')->on('jornada_categorias');
            $table->foreign('id_jornada')->references('id')->on('jornada');
            $table->foreign('status')->references('id')->on('cod_tipo');
            $table->foreign('id_categoria')->references('id')->on('grupo_categoria');
            $table->foreign('sede')->references('id')->on('sede');
            $table->foreign('arbitro')->references('id')->on('arbitro');
            $table->foreign('id_equipo_local')->references('id')->on('equipos');
            $table->foreign('id_equipo_visitante')->references('id')->on('equipos');

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
