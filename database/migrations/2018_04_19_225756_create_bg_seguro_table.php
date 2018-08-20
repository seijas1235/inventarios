<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBgSeguroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bg_seguro', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->date('fecha_compra');

            $tabla->integer('no_pedido');
            $tabla->integer('no_carga');
            $tabla->integer('gal_super');
            $tabla->integer('gal_regular');
            $tabla->integer('gal_diesel');
            $tabla->integer('total_galones');
            $tabla->float('total_seguro');

            $tabla->integer('estado_seguro_id')->unsigned()->nullable();
            $tabla->foreign('estado_seguro_id')->references('id')->on('estado_seguro')->onDelete('cascade');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('estado');

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
        Schema::drop('bg_seguro');
    }
}
