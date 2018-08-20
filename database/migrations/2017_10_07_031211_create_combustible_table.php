<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombustibleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combustible', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('combustible',20)->unique();

            $tabla->integer('tipo_servicio_id')->unsigned()->nullable();
            $tabla->foreign('tipo_servicio_id')->references('id')->on('tipo_servicio')->onDelete('cascade');

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
        Schema::drop('combustible');
    }
}
