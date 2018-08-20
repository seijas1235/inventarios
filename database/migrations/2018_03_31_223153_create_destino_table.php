<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destino', function (Blueprint $tabla) {
            $tabla->increments('id');
            $tabla->string('nombre',150);
            $tabla->string('contacto',50);
            $tabla->string('telefonos',30);
            $tabla->string('ubicacion',150);
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
        Schema::drop('destino');
    }
}
