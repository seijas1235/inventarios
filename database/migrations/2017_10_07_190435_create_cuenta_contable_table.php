<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaContableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_contable', function (Blueprint $tabla) {
            
            $tabla->increments('id');
            $tabla->string('codigo',20);
            $tabla->string('descripcion',50);
            
            $tabla->integer('tipo_cc_id')->unsigned()->nullable();
            $tabla->foreign('tipo_cc_id')->references('id')->on('tipo_cuenta_contable')->onDelete('cascade');

            $tabla->integer('estacion_servicio_id')->unsigned()->nullable();
            $tabla->foreign('estacion_servicio_id')->references('id')->on('estacion_servicio')->onDelete('cascade');

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
        Schema::drop('cuenta_contable');
    }
}
