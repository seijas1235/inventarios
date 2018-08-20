<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaCambiariaMaestrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_cambiaria_maestro', function (Blueprint $tabla) {
            $tabla->increments('id');

            $tabla->integer('cliente_id')->unsigned()->nullable();
            $tabla->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $tabla->integer('serie_id')->unsigned()->nullable();
            $tabla->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');

            $tabla->integer('estado_id')->unsigned()->nullable();
            $tabla->integer('no_factura');

            $tabla->string('nit',15);
            $tabla->string('direccion',50);

            $tabla->float('total');
            $tabla->float('total_pagado');
            $tabla->float('total_por_pagar');

            $tabla->float('idp_regular');
            $tabla->float('idp_super');
            $tabla->float('idp_diesel');
            $tabla->float('idp_total');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->date('fecha_factura');

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
        Schema::drop('factura_cambiaria_maestro');
    }
}
