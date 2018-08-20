<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCamionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('camion', function (Blueprint $tabla) {
            $tabla->increments('id');
            $tabla->string('nombre',10);
            $tabla->string('placa',10);
            $tabla->string('observaciones',100);
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
        Schema::drop('camion');
    }
}
