<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_tipo', function (Blueprint $table) {
            $table->id();
            $table->string('cod_padre')->nullable();
            $table->string('cod_tipo')->nullable();
            $table->string('nombre')->nullable();
            $table->integer('status')->default(1);
            $table->string('color')->nullable();
            $table->string('icons')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cod_tipo');
    }
}
