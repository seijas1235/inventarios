<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReciboCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo_caja', function (Blueprint $tabla) {
            $tabla->increments('id');

            $tabla->date('fecha_recibo');

            $tabla->string('nit',15);
            $tabla->integer('no_recibo_caja');

            $tabla->integer('cliente_id')->unsigned()->nullable();
            $tabla->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('banco_id')->unsigned()->nullable();
            $tabla->foreign('banco_id')->references('id')->on('banco')->onDelete('cascade');

            $tabla->integer('tipo_pago_id')->unsigned()->nullable();
            $tabla->foreign('tipo_pago_id')->references('id')->on('tipos_pagos')->onDelete('cascade');

            $tabla->float('saldo_anterior');
            $tabla->float('saldo_actual');

            $tabla->float('monto');
            $tabla->float('monto_pagado');
            $tabla->string('cheque',15);

            $tabla->integer('concepto_id');
            $tabla->integer('estado_id');
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
        Schema::drop('recibo_caja');
    }
}
