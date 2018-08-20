<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaCobrarDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_cobrar_detalle', function($tabla)
        {
            $tabla->increments('id');

            $tabla->integer('cuenta_cobrar_maestro_id')->unsigned()->nullable();
            $tabla->foreign('cuenta_cobrar_maestro_id')->references('id')->on('cuenta_cobrar_maestro')->onDelete('cascade');

            $tabla->integer('tipo_transaccion');
            $tabla->date('fecha_documento');
            $tabla->integer('documento_id');
            $tabla->float('total');
            $tabla->float('saldo');

            $tabla->integer('estado_cuenta_cobrar_id')->unsigned()->nullable();
            $tabla->foreign('estado_cuenta_cobrar_id')->references('id')->on('estado_cuenta_cobrar')->onDelete('cascade');

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
        Schema::drop('cuenta_cobrar_detalle');
    }
}
