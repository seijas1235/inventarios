<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaLubDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
    {
        Schema::create('factura_lub_detalle', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->integer('factura_lub_maestro_id')->unsigned()->nullable();
            $tabla->foreign('factura_lub_maestro_id')->references('id')->on('factura_lub_maestro')->onDelete('cascade');

            $tabla->integer('cantidad');

            $tabla->integer('producto_id')->unsigned()->nullable();
            $tabla->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $tabla->integer('unidad_medida_id')->unsigned()->nullable();
            $tabla->foreign('unidad_medida_id')->references('id')->on('unidad_medida')->onDelete('cascade');

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
        Schema::drop('factura_lub_maestro');
    }
}
