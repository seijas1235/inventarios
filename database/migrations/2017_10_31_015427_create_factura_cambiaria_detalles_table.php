<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaCambiariaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_cambiaria_detalle', function (Blueprint $tabla) {
            $tabla->increments('id');

            $tabla->integer('factura_cambiaria_maestro_id')->unsigned()->nullable();
            $tabla->foreign('factura_cambiaria_maestro_id')->references('id')->on('factura_cambiaria_maestro')->onDelete('cascade');

            $tabla->float('cantidad');
            $tabla->float('subtotal');
            $tabla->integer('producto_id');
            $tabla->integer('tipo_producto_id');
            $tabla->integer('combustible_id');

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
        Schema::drop('factura_cambiaria_detalle');
    }
}
