<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReciboValesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('recibo_caja_vale', function (Blueprint $tabla) {
           
            $tabla->increments('id');

            $tabla->integer('vale_id')->unsigned()->nullable();
            $tabla->foreign('vale_id')->references('id')->on('vale_maestro')->onDelete('cascade');

            $tabla->integer('recibo_caja_id')->unsigned()->nullable();             
            $tabla->foreign('recibo_caja_id')->references('id')->on('recibo_caja')->onDelete('cascade');

            $tabla->float('total');

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
          Schema::drop('recibo_caja_vale');
    }
}
