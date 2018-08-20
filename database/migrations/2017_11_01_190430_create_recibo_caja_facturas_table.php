<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReciboCajaFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo_caja_factura', function (Blueprint $tabla) {
            $tabla->increments('id');
            
            $tabla->integer('factura_cambiaria_id')->unsigned()->nullable();
            $tabla->foreign('factura_cambiaria_id')->references('id')->on('factura_cambiaria_maestro')->onDelete('cascade');

            $tabla->integer('recibo_caja_id')->unsigned()->nullable();
            $tabla->foreign('recibo_caja_id')->references('id')->on('recibo_caja')->onDelete('cascade');

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
        Schema::drop('recibo_caja_factura');
    }
}
