<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaCreditoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_credito_detalle', function (Blueprint $tabla) {
            $tabla->increments('id');

            $tabla->integer('nota_credito_maestro_id')->unsigned()->nullable();
            $tabla->foreign('nota_credito_maestro_id')->references('id')->on('nota_credito_maestro')->onDelete('cascade');

            $tabla->integer('producto_id');
            $tabla->integer('combustible_id');

            $tabla->float('cantidad');
            $tabla->float('subtotal');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('tipo_producto_id');

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
        Schema::drop('nota_credito_detalle');
    }
}
