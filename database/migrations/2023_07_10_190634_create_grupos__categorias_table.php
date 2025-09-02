<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo_categoria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('grupo_id');
            $table->foreign('categoria_id')->references('id')->on('categoria');
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupos__categorias');
    }
}
