<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $tabla) {
            $tabla->increments('id');
            $tabla->string('serie',10);
            $tabla->string('resolucion',30);
            $tabla->date('fecha_resolucion');
            $tabla->integer('num_inferior');
            $tabla->integer('num_superior');
            $tabla->date('fecha_vencimiento');
            $tabla->integer('num_actual');
            $tabla->integer('estado_serie_id');

            $tabla->integer('documento_id')->unsigned()->nullable();
            $tabla->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');

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
        Schema::drop('series');
    }
}
