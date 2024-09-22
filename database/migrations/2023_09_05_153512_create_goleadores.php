<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoleadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goleadores', function (Blueprint $table) {
            $table->id();
            $table->integer('lugar')->nullable();
            $table->unsignedBigInteger('jugador_id');
            $table->integer('cant_goles');
            $table->string('efectividad')->nullable();
            $table->foreign('jugador_id')->references('id')->on('jugadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goleadores');
    }
}
