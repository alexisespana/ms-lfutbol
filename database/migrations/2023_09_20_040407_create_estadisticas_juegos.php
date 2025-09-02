<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadisticasJuegos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadisticas_juegos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('juego_id');
            $table->string('titulares_eq_local')->nullable();
            $table->string('suplentes_eq_local')->nullable();
            $table->string('cambio_entra_eq_local')->nullable();
            $table->string('cambio_sale_eq_local')->nullable();
            $table->string('min_cambio_eq_local')->nullable();
            $table->string('goles_eq_local')->nullable();
            $table->string('min_goles_eq_local')->nullable();
            $table->string('tarjeta_ama_eq_local')->nullable();
            $table->string('min_ama_eq_local')->nullable();
            $table->string('tarjeta_roja_eq_local')->nullable();
            $table->string('min_roja_eq_local')->nullable();
            $table->string('titulares_eq_visit')->nullable();
            $table->string('suplentes_eq_visit')->nullable();
            $table->string('cambio_entra_eq_visit')->nullable();
            $table->string('cambio_sale_eq_visit')->nullable();
            $table->string('min_cambio_eq_visit')->nullable();
            $table->string('goles_eq_visit')->nullable();
            $table->string('min_goles_eq_visit')->nullable();
            $table->string('tarjeta_ama_eq_visit')->nullable();
            $table->string('min_ama_eq_visit')->nullable();
            $table->string('tarjeta_roja_eq_visit')->nullable();
            $table->string('min_roja_eq_visit')->nullable();
            $table->timestamps();

            $table->foreign('juego_id')->references('id')->on('juegos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estadisticas_juegos');
    }
}
