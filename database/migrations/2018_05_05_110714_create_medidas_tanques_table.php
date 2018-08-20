<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedidasTanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('medidas_tanques', function (Blueprint $tabla) {

            $tabla->increments('id');
            $tabla->date('fecha_medida');

            $tabla->string('med_regla_super');
            $tabla->string('med_regla_regular');
            $tabla->string('med_regla_diesel');
            $tabla->float('med_tabla_super');
            $tabla->float('med_tabla_regular');
            $tabla->float('med_tabla_diesel');

            $tabla->integer('empleado_id')->unsigned()->nullable();
            $tabla->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            
            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('estado');

            $tabla->string('observaciones',200);
            
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
        Schema::drop('medidas_tanques');
    }
}
