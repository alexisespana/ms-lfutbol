<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportajeResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportaje_resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_resultado');
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('img_principal');
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->timestamps();
            $table->foreign('id_resultado')->references('id')->on('resultados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportaje_resultados');
    }
}
