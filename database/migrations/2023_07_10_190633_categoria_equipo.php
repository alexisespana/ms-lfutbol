<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoriaEquipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_equipo', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('equipo_id');
            $table->unsignedBigInteger('grupo')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categoria');
            $table->foreign('equipo_id')->references('id')->on('equipos');
            $table->foreign('grupo')->references('id')->on('grupos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria_equipo');
    }
}
