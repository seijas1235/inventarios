<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoCuentaEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_cuenta_empleado', function (Blueprint $tabla) {
            
            $tabla->increments('id');
            $tabla->date('fecha_transaccion');

            $tabla->integer('empleado_id')->unsigned()->nullable();
            $tabla->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');

            $tabla->string('no_documento',12);
            $tabla->string('documento',15);                 

            $tabla->float('cargos');
            $tabla->float('abonos');
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
        Schema::drop('estado_cuenta_empleado');
    }
}
