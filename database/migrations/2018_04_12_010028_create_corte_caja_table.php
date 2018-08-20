<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorteCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corte_caja', function (Blueprint $tabla) {
            $tabla->increments('id');
            $tabla->date('fecha_corte');
            $tabla->string('codigo_corte',12);

            $tabla->float('lubricantes');
            $tabla->float('gal_super');
            $tabla->float('total_super');
            $tabla->float('gal_regular');
            $tabla->float('total_regular');
            $tabla->float('gal_diesel');
            $tabla->float('total_diesel');
            $tabla->float('combustible');
            $tabla->float('total_ventas');

            $tabla->float('deposito_grande');
            $tabla->float('deposito_colas');
            $tabla->float('deposito_posterior');
            $tabla->float('total_efectivo');
            $tabla->float('tarjeta');
            $tabla->float('vales');
            $tabla->float('gastos');
            $tabla->float('devoluciones');
            $tabla->float('faltantes');
            $tabla->float('cupones');
            $tabla->float('anticipo_empleado');
            $tabla->float('calibraciones');
            $tabla->float('gastos_bg');
            $tabla->float('total_ventas_turno');
            $tabla->string('observaciones',150);

            $tabla->string('resultado_turno');
            $tabla->float('resultado_q');

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
        Schema::drop('requisicion');
    }
}
