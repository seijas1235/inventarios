<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValeDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vale_detalle', function($tabla)
        {
            $tabla->increments('id');
            $tabla->float('cantidad');
            $tabla->float('precio_compra');
            $tabla->float('precio_venta');

            $tabla->float('subtotal');
            $tabla->integer('combustible_id');

            $tabla->integer('producto_id');
            $tabla->integer('tipo_producto_id');

            $tabla->integer('vale_maestro_id')->unsigned()->nullable();
            $tabla->foreign('vale_maestro_id')->references('id')->on('vale_maestro')->onDelete('cascade');

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
     Schema::drop('vale_detalle');

 }
}
