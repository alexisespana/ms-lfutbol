<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornadaCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornada_categorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jornada_id');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('jornada_id')->references('id')->on('jornada');
            $table->foreign('categoria_id')->references('id')->on('grupo_categoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jornada_categorias');
    }
}
