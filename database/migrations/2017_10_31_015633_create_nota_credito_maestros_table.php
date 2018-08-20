<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaCreditoMaestrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_credito_maestro', function (Blueprint $tabla) {
            $tabla->increments('id');

            $tabla->date('fecha');

            $tabla->integer('cliente_id')->unsigned()->nullable();
            $tabla->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('codigo_id');
            $tabla->integer('estado_id');
            $tabla->integer('tipo_id');
            $tabla->integer('concepto_id');
            $tabla->float('monto');

            $tabla->float('idp_regular');
            $tabla->float('idp_super');
            $tabla->float('idp_diesel');
            $tabla->float('idp_total');

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
        Schema::drop('nota_credito_maestro');
    }
}
