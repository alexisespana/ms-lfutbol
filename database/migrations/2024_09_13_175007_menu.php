<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Menu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo');
            $table->string('nombre');
            $table->string('href');
            $table->integer('id_menupadre');
            $table->integer('orden');
            $table->timestamps();
            // $table->foreign('id_menupadre')->references('id')->on('menu_padre');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
