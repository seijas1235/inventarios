<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegracionCapitalMesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integracion_capital_mes', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->integer('mes_id')->unsigned()->nullable();
            $tabla->foreign('mes_id')->references('id')->on('meses')->onDelete('cascade');

            $tabla->integer('anio');            


            $tabla->integer('estado');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
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
        Schema::drop('integracion_capital_mes');
    }
}
