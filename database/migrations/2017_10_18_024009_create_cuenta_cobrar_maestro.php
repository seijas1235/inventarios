<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaCobrarMaestro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_cobrar_maestro', function($tabla)
        {
            $tabla->increments('id');

            $tabla->integer('cliente_id')->unsigned()->nullable();
            $tabla->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $tabla->integer('estacion_id')->unsigned()->nullable();

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
        Schema::drop('cuenta_cobrar_maestro');
    }
}
