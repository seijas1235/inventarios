<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaValesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_vales', function (Blueprint $tabla) {
            $tabla->increments('id');

            $tabla->integer('nota_credito_id')->unsigned()->nullable();
            $tabla->foreign('nota_credito_id')->references('id')->on('nota_credito_maestro')->onDelete('cascade');

            $tabla->integer('vale_maestro_id')->unsigned()->nullable();
            $tabla->foreign('vale_maestro_id')->references('id')->on('vale_maestro')->onDelete('cascade');

            $tabla->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nota_vales');
    }
}
