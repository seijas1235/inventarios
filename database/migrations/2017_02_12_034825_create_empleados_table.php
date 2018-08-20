<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('emp_cui',13)->unique();
            $tabla->string('emp_nombres',30);
            $tabla->string('emp_apellidos',30);
            $tabla->string('emp_direccion',50);
            $tabla->string('emp_telefonos',30);

            $tabla->integer('estado_empleado_id')->unsigned()->nullable();
            $tabla->foreign('estado_empleado_id')->references('id')->on('estados_empleado')->onDelete('cascade');

            $tabla->integer('cargo_empleado_id')->unsigned()->nullable();
            $tabla->foreign('cargo_empleado_id')->references('id')->on('cargos_empleado')->onDelete('cascade');

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
        Schema::drop('empleados');
    }
}
