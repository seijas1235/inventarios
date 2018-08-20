<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_facturas', function (Blueprint $tabla) {
            $tabla->increments('id');

            $tabla->integer('nota_credito_id')->unsigned()->nullable();
            $tabla->foreign('nota_credito_id')->references('id')->on('nota_credito_maestro')->onDelete('cascade');

            $tabla->integer('factura_cambiaria_id')->unsigned()->nullable();
            $tabla->foreign('factura_cambiaria_id')->references('id')->on('factura_cambiaria_maestro')->onDelete('cascade');

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
        Schema::drop('nota_facturas');
    }
}
