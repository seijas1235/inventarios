<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValeMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vale_maestro', function($tabla)
        {
            $tabla->increments('id');

            $tabla->date('fecha_corte');
            $tabla->string('codigo_corte',12);

            $tabla->float('total_vale');
            $tabla->float('total_pagado');
            $tabla->float('total_por_pagar');
            $tabla->string('piloto',50);
            $tabla->string('placa',50);
            $tabla->string('observaciones',150);
            $tabla->integer('factura_cambiaria_id');

            $tabla->integer('tipo_servicio');
            $tabla->integer('no_vale');
            
            $tabla->integer('estado_vale_id')->unsigned()->nullable();
            $tabla->foreign('estado_vale_id')->references('id')->on('estado_vale')->onDelete('cascade');

            $tabla->integer('estado_corte_id')->unsigned()->nullable();
            $tabla->foreign('estado_corte_id')->references('id')->on('estado_corte')->onDelete('cascade');

            $tabla->integer('bomba_id')->unsigned()->nullable();
            $tabla->foreign('bomba_id')->references('id')->on('bomba')->onDelete('cascade');

             $tabla->integer('cliente_id')->unsigned()->nullable();
            $tabla->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $tabla->integer('tipo_vehiculo_id')->unsigned()->nullable();
            $tabla->foreign('tipo_vehiculo_id')->references('id')->on('tipo_vehiculo')->onDelete('cascade');

            $tabla->float('idp_regular');
            $tabla->float('idp_super');
            $tabla->float('idp_diesel');
            $tabla->float('idp_total');

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
             Schema::drop('vale_maestro');

   }
}
