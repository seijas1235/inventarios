<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBgFletesDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bg_fletes_detalle', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->integer('bg_flete_maestro_id')->unsigned()->nullable();
            $tabla->foreign('bg_flete_maestro_id')->references('id')->on('bg_fletes_maestro')->onDelete('cascade');

            $tabla->integer('combustible_id')->unsigned()->nullable();
            $tabla->foreign('combustible_id')->references('id')->on('combustible')->onDelete('cascade');

            $tabla->integer('tanque_id')->unsigned()->nullable();
            $tabla->foreign('tanque_id')->references('id')->on('tanque')->onDelete('cascade');

            $tabla->integer('galones');
            $tabla->float('precio_compra');
            $tabla->float('subtotal');

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
        Schema::drop('bg_fletes_detalle');
    }
}
