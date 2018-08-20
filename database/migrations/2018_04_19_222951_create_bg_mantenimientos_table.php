<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBgMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('bg_mantenimientos', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->date('fecha_corte');
            $tabla->string('codigo_corte',12);

            $tabla->string('documento',20);
            $tabla->string('no_documento',15);
            $tabla->string('descripcion',200);
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
        Schema::drop('bg_mantenimientos');
    }
}
