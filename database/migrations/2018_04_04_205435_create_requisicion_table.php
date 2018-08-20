<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisicionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicion', function (Blueprint $tabla) {
            $tabla->increments('id');
            $tabla->date('fecha_requisicion');

            $tabla->integer('empleado_solicita_id')->unsigned()->nullable();
            $tabla->foreign('empleado_solicita_id')->references('id')->on('empleados')->onDelete('cascade');

            $tabla->string('pagar_a',150);

            $tabla->integer('cuenta_contable_id')->unsigned()->nullable();
            $tabla->foreign('cuenta_contable_id')->references('id')->on('cuenta_contable')->onDelete('cascade');

            $tabla->float('monto');
            $tabla->string('concepto',200);

            $tabla->integer('user_crea_id')->unsigned()->nullable();
            $tabla->foreign('user_crea_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->string('razon_rechazo',200);
            $tabla->datetime('fecha_rechazo');

            $tabla->integer('user_rechaza_id')->unsigned()->nullable();
            $tabla->foreign('user_rechaza_id')->references('id')->on('users')->onDelete('cascade');
            
            $tabla->string('razon_autoriza',200);
            $tabla->datetime('fecha_autoriza');

            $tabla->integer('user_autoriza_id')->unsigned()->nullable();
            $tabla->foreign('user_autoriza_id')->references('id')->on('users')->onDelete('cascade');
            
            $tabla->string('razon_anulacion',200);
            $tabla->datetime('fecha_anulacion');

            $tabla->integer('user_anula_id')->unsigned()->nullable();
            $tabla->foreign('user_anula_id')->references('id')->on('users')->onDelete('cascade');
            
            $tabla->integer('estado_requisicion_id')->unsigned()->nullable();
            $tabla->foreign('estado_requisicion_id')->references('id')->on('estado_requisicion')->onDelete('cascade');
            
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
