<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanque', function (Blueprint $tabla) {
            $tabla->increments('id');

            $tabla->string('nombre_tanque', 10);

            $tabla->integer('combustible_id')->unsigned()->nullable();
            $tabla->foreign('combustible_id')->references('id')->on('combustible')->onDelete('cascade');

            $tabla->integer('capacidad');

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
        Schema::drop('tanque');
    }
}
