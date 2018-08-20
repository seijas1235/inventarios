<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnticipoEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticipo_empleados', function (Blueprint $tabla) {
            
            $tabla->increments('id');

            $tabla->date('fecha_corte');
            $tabla->string('codigo_corte',12);

            $tabla->integer('empleado_id')->unsigned()->nullable();
            $tabla->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');

            $tabla->string('no_documento',12);
            $tabla->string('documento',20);                 

            $tabla->float('monto');
            $tabla->string('observaciones',200);

            $tabla->integer('estado_corte_id')->unsigned()->nullable();
            $tabla->foreign('estado_corte_id')->references('id')->on('estado_corte')->onDelete('cascade');

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
        Schema::drop('anticipo_empleados');
    }
}
