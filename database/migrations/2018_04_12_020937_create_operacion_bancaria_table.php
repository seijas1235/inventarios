<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperacionBancariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operacion_bancaria', function (Blueprint $tabla) {
            
            $tabla->increments('id');
            $tabla->date('fecha_transaccion');

            $tabla->integer('cuenta_id');

            $tabla->integer('documento_id')->unsigned()->nullable();
            $tabla->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');

            $tabla->integer('no_documento');

            $tabla->float('debitos');
            $tabla->float('creditos');
            $tabla->float('saldo');

            $tabla->string('descripcion',200);
            
            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('estado');
            
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
        Schema::drop('operacion_bancaria');
    }
}
