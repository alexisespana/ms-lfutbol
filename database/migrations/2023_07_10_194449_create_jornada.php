<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_temporada');
            $table->unsignedBigInteger('id_categoria');
            $table->string('nombre')->nullable();
            $table->string('fecha')->nullable();
            $table->string('vigente')->default(0);
            $table->foreign('id_temporada')->references('id')->on('temporada');
            $table->foreign('id_categoria')->references('id')->on('categoria');

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
        Schema::dropIfExists('jornada');
    }
}
