<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstacionServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estacion_servicio', function (Blueprint $tabla) {
            
            $tabla->increments('id');
            $tabla->string('nombre_estacion',50);
            $tabla->string('ubicacion',200);
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
        Schema::drop('estacion_servicio');
    }
}
