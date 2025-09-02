<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_juego');
            $table->unsignedBigInteger('status');
            $table->string('cant_goles_eqlocal')->nullable();
            $table->string('cant_goles_eqvisit')->nullable();

            $table->timestamps();
            $table->foreign('id_juego')->references('id')->on('juegos');
            $table->foreign('status')->references('id')->on('cod_tipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultados');
    }
}
